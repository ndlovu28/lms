<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected string $baseUrl;

    protected string $authUrl;

    protected string $clientId;

    protected string $clientSecret;

    protected string $accountId;

    public function __construct()
    {
        $this->baseUrl = config('services.zoom.base_url');
        $this->authUrl = config('services.zoom.auth_url');
        $this->clientId = config('services.zoom.client_id') ?? '';
        $this->clientSecret = config('services.zoom.client_secret') ?? '';
        $this->accountId = config('services.zoom.account_id') ?? '';
    }

    /**
     * Get or refresh the access token.
     */
    protected function getAccessToken(): string
    {
        return Cache::remember('zoom_access_token', 3500, function () {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post($this->authUrl, [
                    'grant_type' => 'account_credentials',
                    'account_id' => $this->accountId,
                ]);

            if ($response->failed()) {
                throw new \Exception('Zoom Authentication Failed: '.$response->body());
            }

            return $response->json()['access_token'];
        });
    }

    /**
     * Create a Zoom meeting for a course.
     */
    public function createMeeting(Course $course): array
    {
        $response = Http::withToken($this->getAccessToken())
            ->post("{$this->baseUrl}users/me/meetings", [
                'topic' => "Live Session: {$course->name}",
                'type' => 2, // Scheduled meeting
                'start_time' => now()->toIso8601String(),
                'duration' => 60,
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'mute_upon_entry' => true,
                    'waiting_room' => false,
                ],
            ]);

        if ($response->failed()) {
            throw new \Exception('Zoom Meeting Creation Failed: '.$response->body());
        }

        return $response->json();
    }
}
