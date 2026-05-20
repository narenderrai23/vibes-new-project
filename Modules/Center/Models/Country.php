<?php

namespace Modules\Center\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'iso2', 'iso3', 'phonecode', 'currency'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
