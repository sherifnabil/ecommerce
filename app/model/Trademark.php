<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    protected $table = 'trademarks';
    protected $fillable = [
        'name_ar',
        'name_en',
        'logo',
    ];


}
