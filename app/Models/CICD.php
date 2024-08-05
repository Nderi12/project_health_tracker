<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CICD extends Model
{
    use HasFactory;

    /**
     * Table associated with the model
     *
     * @var string
     */
    protected $table = "cicds";
}
