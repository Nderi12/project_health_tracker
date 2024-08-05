<?php

namespace App\Transformers;

use App\Models\Rider;
use League\Fractal\TransformerAbstract;

class RiderAccessTransformer extends TransformerAbstract
{

    protected $pass;

    public function __construct($pass) {
        $this->pass = $pass;
    }
    
    public function transform(Rider $user)
    {
        return [
            "success" => true,
            "user" => $user,
            "token" => $user->createToken($this->pass)->plainTextToken
        ];
    }
}
