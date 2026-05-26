<?php

namespace Modules\Center\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Authenticatable login account for a center staff member.
 * Linked to the centers table via center_id.
 */
class CenterUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'center';

    protected $table = 'center_users';

    protected $fillable = [
        'center_id',
        'name',
        'email',
        'password',
        'mobile',
        'role',        // e.g. manager, receptionist, staff
        'avatar',
        'status',
        'last_login',
        'last_ip',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'last_login'        => 'datetime',
            'deleted_at'        => 'datetime',
            'status'            => 'integer',
        ];
    }

    /**
     * The center this user belongs to.
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
