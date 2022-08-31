<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRevision extends Model
{
    use HasFactory;

    protected $table = 'price_revisions';

    protected $fillable = [
        'display',
        'name',
        'color',
        'mode',
        'same_size',
        'pointer',
        'coupon',
        'post_price',
        'ignore'
    ];
}
