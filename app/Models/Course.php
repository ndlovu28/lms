<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'school_id',
        'tutor_id',
        'phase_id',
        'name',
        'description',
    ];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function liveSessions(): HasMany
    {
        return $this->hasMany(LiveSession::class);
    }

    public function activeSession(): HasOne
    {
        return $this->hasOne(LiveSession::class)->where('is_active', true);
    }
}
