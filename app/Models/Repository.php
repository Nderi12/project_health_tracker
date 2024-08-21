<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'description',
        'organization_id'
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
