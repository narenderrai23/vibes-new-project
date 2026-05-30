<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'student';

    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'gender',
        'date_of_birth',
        'address',
        'avatar',
        'status',
        'enrollment_number',
        'course',
        'batch',
        'last_login',
        'last_ip',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'date_of_birth'     => 'date',
            'last_login'        => 'datetime',
            'deleted_at'        => 'datetime',
            'status'            => 'integer',
        ];
    }

    /**
     * Status label as an HTML badge (for datatables / show pages).
     */
    public function getStatusLabelAttribute(): string
    {
        return match ((int) ($this->attributes['status'] ?? -1)) {
            0       => '<span class="badge bg-danger">Inactive</span>',
            1       => '<span class="badge bg-success">Active</span>',
            2       => '<span class="badge bg-warning text-dark">Pending</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    protected static function newFactory()
    {
        return \Modules\Student\database\factories\StudentFactory::new();
    }
}
