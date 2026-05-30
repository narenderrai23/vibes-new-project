<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Student\Models\Student;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $table = 'course_enrollments';

    protected $fillable = [
        'student_id', 'course_id', 'started_at', 'expires_at', 'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'status' => 'integer',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function moduleCompletions(): HasMany
    {
        return $this->hasMany(ModuleCompletion::class);
    }

    public function contentViews(): HasMany
    {
        return $this->hasMany(ContentView::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 1)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function isModuleUnlocked(CourseModule $module): bool
    {
        $previous = CourseModule::where('course_id', $this->course_id)
            ->where('position', '<', $module->position)
            ->orderByDesc('position')
            ->first();

        if (! $previous) {
            return true;
        }

        $completion = $this->moduleCompletions()
            ->where('course_module_id', $previous->id)
            ->first();

        if (! $completion) {
            return false;
        }

        if ($previous->requires_trainer_approval) {
            return (bool) $completion->trainer_approved;
        }

        return (bool) $completion->completed_at;
    }
}
