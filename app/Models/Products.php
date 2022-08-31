<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'site_url',
        'product_id',
        'product_img',
        'product_name',
        'product_comment',
        'category',

        'brand',
        'season_',
        'theme_',

        'size_color',
        'delivery',
        'deadline',
        'place',
        'shop_name_',
        'shipping_place',

        'product_price',
        'normal_pirce_',
        'tariff_',
        'exhibition_memo_',
        'purchase_memo_',
        'created_at',
        'updated_at',
    ];

    public function r_time_pattern() {
        return $this->belongsTo(
            TimePattern::class,
            'r_time_condition'
        );
    }

    public function y_time_pattern() {
        return $this->belongsTo(
            TimePattern::class,
            'y_time_condition'
        );
    }
}
