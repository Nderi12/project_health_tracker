<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'agency_type',
        'agency_code',
        'status',
        'created_by',
        'updated_by',
    ];

    public function agencyUser()
    {
        return $this->hasMany('App\Models\AgencyUser');
    }

    public function agencyRole()
    {
        return $this->hasMany('App\Models\AgencyRole');
    }

    public function agencyService()
    {
        return $this->hasMany('App\Models\AgencyService');
    }

    public function agencyStation()
    {
        return $this->hasMany('App\Models\AgencyStation');
    }

    public function roles()
    {
        return $this->hasMany('App\Models\AgencyRole', 'agency_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AgencyType::class, 'agency_type', 'id');
    }

}
