<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_contents';

    protected $fillable = [
        'course_module_id', 'title', 'summary', 'type',
        'source', 'external_id', 'external_url',
        'storage_disk', 'storage_path', 'mime', 'size_bytes',
        'position', 'release_day', 'release_at', 'downloadable', 'language',
    ];

    protected function casts(): array
    {
        return [
            'release_at' => 'datetime',
            'downloadable' => 'boolean',
            'release_day' => 'integer',
            'position' => 'integer',
        ];
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    /**
     * True when this content streams from an external provider (Vimeo) rather
     * than an uploaded file on a private disk.
     */
    public function isExternal(): bool
    {
        return $this->source === 'vimeo';
    }

    /**
     * Extract the numeric Vimeo id from any common Vimeo link or a bare id.
     * Supports vimeo.com/123, player.vimeo.com/video/123, and private links
     * such as vimeo.com/123/abcdef (the hash is preserved in external_url).
     */
    public static function parseVimeoId(string $input): ?string
    {
        $input = trim($input);

        if (ctype_digit($input)) {
            return $input;
        }

        if (preg_match('~vimeo\.com/(?:video/|channels/[^/]+/|groups/[^/]+/videos/)?(\d+)~i', $input, $m)) {
            return $m[1];
        }

        return null;
    }

    /**
     * Player embed URL for a Vimeo video. Returns null for non-Vimeo content.
     * Disables the download button and hides extra player chrome.
     */
    public function vimeoEmbedUrl(): ?string
    {
        if (! $this->isExternal() || ! $this->external_id) {
            return null;
        }

        $params = http_build_query([
            'badge'    => 0,
            'autopause' => 0,
            'byline'   => 0,
            'portrait' => 0,
            'title'    => 0,
            'dnt'      => 1,
        ]);

        return "https://player.vimeo.com/video/{$this->external_id}?{$params}";
    }

    public function isReleasedFor(CourseEnrollment $enrollment, ?\DateTimeInterface $now = null): bool
    {
        $now ??= now();

        if ($this->release_at && $this->release_at->isFuture()) {
            return false;
        }

        if (! $enrollment->started_at) {
            return $this->release_day <= 1;
        }

        $daysSinceStart = $enrollment->started_at->diffInDays($now) + 1;

        return $daysSinceStart >= $this->release_day;
    }
}
