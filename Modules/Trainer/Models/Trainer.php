<?php

namespace Modules\Trainer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trainer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'trainer';

    protected $table = 'trainers';

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
        'specialization',
        'qualification',
        'experience_years',
        'bio',
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
            'experience_years'  => 'integer',
        ];
    }

    protected static function newFactory()
    {
        return \Modules\Trainer\database\factories\TrainerFactory::new();
    }
}
