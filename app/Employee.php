<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [
        'id',
    ];

    function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    function getCity()
    {
        return $this->hasOne(Regency::class, 'id', 'city_address');
    }
}
