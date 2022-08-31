<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'email_verified_at',
        'password',        
        'role',        
        'family_name',
        'cell_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    public function selected_pattern() {
        return $this->hasMany(
            UserProductPattern::class,
            'user_id'
        );
    }

    public function custom_price_pattern() {
        return $this->hasMany(
            CustomPricePattern::class,
            'user_id'
        );
    }

    public function custom_time_pattern() {
        return $this->hasMany(
            CustomTimePattern::class,
            'user_id'
        );
    }

    public function competition_list() {
        return $this->hasOne(
            Competition::class,
            'user_id'
        );
    }
}
