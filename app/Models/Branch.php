<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'repository_id',
        'name'
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function commits()
    {
        return $this->hasMany(Commit::class);
    }
}
