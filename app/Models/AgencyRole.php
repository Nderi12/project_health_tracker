<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agency_id',
        'title',
        'description',
        'created_by',
        'updated_by',
        'status',
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency');
    }

    public function roleRight()
    {
        return $this->hasMany('App\Models\RoleRight');
    }

    public function agencyUser()
    {
        return $this->hasMany('App\Models\AgencyUser');
    }

    /**
     * @return User
     */
    public function updatedBy()
    {
        return User::find($this->updated_by);
    }
}
