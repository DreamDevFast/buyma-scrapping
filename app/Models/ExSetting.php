<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  ExSetting extends Model
{
    use HasFactory;
    protected $table = 'exsettings';

    protected $fillable = [
        'id',
        'user_id',
        'commission',
        'comment'
    ];

}
