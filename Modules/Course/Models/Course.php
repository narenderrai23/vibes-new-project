<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'cover_image',
        'duration_weeks', 'fee_min', 'fee_max',
        'language_default', 'languages_supported', 'status',
    ];

    protected function casts(): array
    {
        return [
            'languages_supported' => 'array',
            'fee_min' => 'decimal:2',
            'fee_max' => 'decimal:2',
            'status' => 'integer',
        ];
    }

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('position');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 1);
    }
}
