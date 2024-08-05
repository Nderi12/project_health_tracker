<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'key', 'description', 'type'
    ];

    /**
     * The relations that should be automatically pulled alongside the model 
     *
     * @var array
     */
    protected $with = [
        'values'
    ];

    /**
     * Get a setting key's values
     *
     * @return HasMany
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function values(): HasMany
    {
        return $this->hasMany(SettingValue::class);
    }

    /**
     * Check the type of a setting
     *
     * @return bool
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function isType(string $type): bool
    {
        return $this->type === $type;
    }
}
