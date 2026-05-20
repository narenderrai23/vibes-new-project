<?php

namespace Modules\Center\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regional extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'regionals';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'code',
        'center_id',
        'status',
    ];

    /**
     * The primary / head center for this regional.
     * Regional belongsTo Center (head center).
     */
    public function headCenter(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * All centers that belong to this regional.
     * Regional hasMany Center.
     */
    public function centers(): HasMany
    {
        return $this->hasMany(Center::class, 'regional_id');
    }
}
