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

    protected static function newFactory()
    {
        return \Modules\Student\database\factories\StudentFactory::new();
    }
}
