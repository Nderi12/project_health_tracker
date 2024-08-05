<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agency_role_id',
        'agency_id',
        'access',
        'status',
        'created_by',
        'updated_by',
    ];

    public function agencyRole(){ return $this->belongsTo('App\Models\AgencyRole'); }

}
