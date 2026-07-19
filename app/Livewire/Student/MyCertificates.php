<?php

namespace App\Livewire\Student;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyCertificates extends Component
{
    public function downloadCertificate($id)
    {
        $certificate = Certificate::with(['student', 'student.school'])->findOrFail($id);

        // Ensure student can only download their own
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        $school = $certificate->student->school;

        $pdf = Pdf::loadView('reports.certificate-template', [
            'certificate' => $certificate,
            'student' => $certificate->student,
            'school' => $school,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Certificate_{$certificate->certificate_number}.pdf");
    }

    public function render()
    {
        $certificates = Certificate::where('user_id', Auth::id())
            // ->with(['subjects', 'issuer'])
            ->latest()
            ->get();

        return view('livewire.student.my-certificates', [
            'certificates' => $certificates,
        ])->layout('layouts.app');
    }
}
