<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPricePattern extends Model
{
    use HasFactory;

    protected $table = 'custom_price_patterns';

    protected $fillable = [
        'display',
        'name',
        'color',
        'mode',
        'same_size',
        'pointer',
        'coupon',
        'post_price',
        'ignore',
        'user_id',
    ];
}
