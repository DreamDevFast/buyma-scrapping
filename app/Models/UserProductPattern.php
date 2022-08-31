<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductPattern extends Model
{
    use HasFactory;

    protected $table = 'user_product_patterns';

    protected $fillable = [
        'user_id',
        'product_id',
        'price_pattern_id',
        'time_pattern_id',
        'market_name',
    ];
}
