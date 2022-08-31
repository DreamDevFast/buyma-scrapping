<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTimePattern extends Model
{
    use HasFactory;

    protected $table = 'custom_time_patterns';

    protected $fillable = [
        'display',
		'name',
		'color',
		'mon',
		'tue',
		'wed',
		'thu',
		'fri',
		'sat',
		'sun',
		'open_time',
		'close_time',
		'open_datetime',
        'close_datetime',
		'is_sale',
		'yen',
		'pro',
        'user_id',
    ];
}
