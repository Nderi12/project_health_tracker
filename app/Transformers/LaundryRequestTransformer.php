<?php

namespace App\Transformers;

use App\Models\LaundryRequest;
use League\Fractal\TransformerAbstract;

use Carbon\Carbon;

class LaundryRequestTransformer extends TransformerAbstract
{

    // protected $pass;

    // public function __construct($pass) {
    //     $this->pass = $pass;
    // }
    
    public function transform(LaundryRequest $laundryRequest)
    {
        return [
            "id" => $laundryRequest->id,
            'weight' => $laundryRequest->weight,
            'amount' => $laundryRequest->weight==null ? 0 : number_format(ceil($laundryRequest->weight*env("PER_KG_LAUNDRY_COST",0))+env("MPESA_TRANSACTION_FEE",0)),
            'special_instructions' => $laundryRequest->special_instructions,
            'payment_status' => $laundryRequest->billTransaction()->where('status',2)->count(),
            'pickup_time' => $laundryRequest->pickup_time,
            'dropoff_time' => $laundryRequest->dropoff_time,
            'user_channel' => $laundryRequest->user_channel,
            'latitude' => $laundryRequest->latitude,
            'longitude' => $laundryRequest->longitude,
            "status" => $laundryRequest->status,
            "created_at" => $laundryRequest->created_at->diffForHumans(),
            "status_updated_at" => Carbon::parse($laundryRequest->status_updated_at)->diffForHumans(),
            'customer' => $laundryRequest->customer,
            'rider_task' => $laundryRequest->riderTask ?? null,
            'laundry_task' => $laundryRequest->laundryTask ?? null,
            'laundromat' => $laundryRequest->laundryTask->laundromat ?? null,
            'bill_transaction' => $laundryRequest->billTransaction ?? null,
        ];
    }
}
