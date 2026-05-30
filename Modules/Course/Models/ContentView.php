<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentView extends Model
{
    protected $table = 'content_views';

    protected $fillable = [
        'course_enrollment_id', 'course_content_id',
        'watch_percent', 'first_viewed_at', 'last_viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'first_viewed_at' => 'datetime',
            'last_viewed_at' => 'datetime',
            'watch_percent' => 'integer',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class, 'course_enrollment_id');
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }
}
