<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    protected $table = 'manufactures';
    protected  $fillable = [
        'name_ar' ,
        'name_en' ,
        'address',
        'facebook',
        'twitter' ,
        'website' ,
        'contact_name',
        'mobile',
        'email',
        'lat'     ,
        'lng'     ,
        'icon'    ,
    ];
}
