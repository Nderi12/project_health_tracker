<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'otpable_id',
        'otpable_type',
        'otp_code',
        'otp_type',
        'status',
    ];

    public function user(){ return $this->belongsTo('App\Models\User'); }

}
