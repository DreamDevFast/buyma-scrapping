<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  ExhibitSetting extends Model
{
    use HasFactory;
    protected $table = 'exhibitsettings';

    protected $fillable = [
        'id',
        'user_id',
        'commission',
        'comment'
    ];

}
