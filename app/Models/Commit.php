<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'sha',
        'message',
        'date'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
