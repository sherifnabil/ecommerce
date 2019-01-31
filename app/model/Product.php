<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',
        'content',
        'photo',
        'other_data',
        'stock',
        'department_id',
        'trade_id',
        'manu_id',
        'color_id',
        'size_id',
        'currency_id',
        'weight',
        'weight_id',
        'price',
        'price_offer',
        'start_at',
        'end_at',
        'start_offer_at',
        'end_offer_at',
        'status',
        'reason',
    ];
}
