<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'description',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
