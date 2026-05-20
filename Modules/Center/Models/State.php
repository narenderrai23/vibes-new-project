<?php

namespace Modules\Center\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $fillable = ['country_id', 'name', 'state_code'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
