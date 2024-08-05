<?php

namespace App\Transformers;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerAccessTransformer extends TransformerAbstract
{

    protected $pass;

    public function __construct($pass) {
        $this->pass = $pass;
    }
    
    public function transform(Customer $user)
    {
        return [
            "success" => true,
            "user" => $user,
            "token" => $user->createToken($this->pass)->plainTextToken
        ];
    }
}
