<?php

namespace App\Transformers;

use App\Models\RiderTask;
use League\Fractal\TransformerAbstract;

class RiderTaskTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(RiderTask $riderTask)
    {
        return [
            'id' => $riderTask->id,
            'weight' => $riderTask->weight,
            'special_instructions' => $riderTask->special_instructions,
            'rider_remarks' => $riderTask->rider_remarks,
            'task_type' => $riderTask->task_type,
            'pickup_time' => $riderTask->pickup_time,
            'dropoff_time' => $riderTask->dropoff_time,
            'user_channel' => $riderTask->user_channel,
            'pickup_latitude' => $riderTask->pickup_latitude,
            'pickup_longitude' => $riderTask->pickup_longitude,
            'dropoff_latitude' => $riderTask->dropoff_latitude,
            'dropoff_longitude' => $riderTask->dropoff_longitude,
            'status_updated_at' => $riderTask->status_updated_at,
            'status' => $riderTask->status,
            'created_at' => $riderTask->created_at." (".$riderTask->created_at->diffForHumans().")",
            'updated_at' => $riderTask->updated_at." (".$riderTask->updated_at->diffForHumans().")",
            'laundry_request' => $riderTask->laundryRequest,
            'customer' => $riderTask->customer,
            'laundromat' => $riderTask->laundryRequest->laundryTask->laundromat,
        ];
    }
}
