<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_public',
        'department_id'
    ];
    public function department_id()
    {
      return  $this->hasOne('App\model\Department', 'id', 'department_id');
    }
}
