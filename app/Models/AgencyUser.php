<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static whereIn(string $string, \Illuminate\Support\Collection $pluck)
 */
class AgencyUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'agency_id',
        'agency_role_id',
        'agency_station_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency');
    }

    public function agencyRole()
    {
        return $this->belongsTo('App\Models\AgencyRole');
    }

    /**
     * @return BelongsTo
     */
    public function station()
    {
        return $this->belongsTo(AgencyStation::class, 'agency_station_id', 'id');
    }

    public function target()
    {
        return $this->hasMany(AgencyUserTarget::class);
    }

    public function bonus()
    {
        return $this->hasMany(AgencyUserBonus::class);
    }

    public function commission()
    {
        return $this->hasMany(AgencyUserCommission::class);
    }
}
