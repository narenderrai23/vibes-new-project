<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleCompletion extends Model
{
    protected $table = 'module_completions';

    protected $fillable = [
        'course_enrollment_id', 'course_module_id', 'completed_at', 'trainer_approved',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
            'trainer_approved' => 'boolean',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class, 'course_enrollment_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }
}
