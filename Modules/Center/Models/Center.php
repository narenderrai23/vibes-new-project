<?php

namespace Modules\Center\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'centers';

    protected $fillable = [
        'code',
        'name',
        'mobile',
        'mobile_alt',
        'email',
        'address',
        'google_link',
        'city',
        'gst_no',
        'state_id',
        'regional_id',
        'status',
    ];

    public function country(): BelongsTo
    {
        // Country is derived via state relationship
        return $this->state?->country ?? $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class);
    }

    public function regionals(): HasMany
    {
        return $this->hasMany(Regional::class, 'center_id');
    }

    protected static function newFactory()
    {
        return \Modules\Center\database\factories\CenterFactory::new();
    }
}
