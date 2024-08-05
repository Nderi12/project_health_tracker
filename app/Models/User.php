<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'email_verified_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
    ];

    public function otpCode()
    {
        return $this->hasMany('App\Models\OtpCode');
    }

    public function fullName()
    {
        return $this->first_name . " " . $this->middle_name . " " . $this->last_name;
    }

    public function shortenedName()
    {
        return $this->first_name . " " . $this->last_name[0].".";
    }

    public function file()
    {
        return $this->hasMany('App\Models\File');
    }
    
    public function agencyUser()
    {
        return $this->hasMany('App\Models\AgencyUser');
    }
}
