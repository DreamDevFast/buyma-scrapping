<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPricePattern extends Model
{
    use HasFactory;

    protected $table = 'default_price_patterns';

    protected $fillable = [
        '_item_id',
        'r_search_kind',
        'y_search_kind',
        'r_same_size',
        'y_same_size',
        'r_point_true',
        'y_point_true',
        'r_coupon',
        'y_coupon',
        'r_deli_true',
        'y_deli_true',
        'r_free_deli_true',
        'y_free_deli_true',
    ];
}
