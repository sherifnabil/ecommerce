<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';
    protected $fillable = [
        'color',
        'name_ar',
        'name_en',
    ];

}
