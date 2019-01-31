<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    protected $table = 'malls';
    protected  $fillable = [
        'name_ar' ,
        'name_en' ,
        'address',
        'facebook',
        'twitter' ,
        'website' ,
        'contact_name',
        'country_id',
        'mobile',
        'email',
        'lat' ,
        'lng' ,
        'icon',
    ];

    public function country_id()
    {
        return $this->hasOne('App\model\Country', 'id', 'country_id');
    }
}
