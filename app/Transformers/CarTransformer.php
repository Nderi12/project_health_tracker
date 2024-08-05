<?php

namespace App\Transformers;

use App\Models\Car;
use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
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
    public function transform(Car $car)
    {
        return [
            'id' => $car->id,
            'registration_number' => $car->registration_number,
            'number_of_visits' => $car->number_of_visits,
            'chasis_number' => $car->chasis_number,
            'make' => $car->make->name,
            'model' => $car->model->name,
            'color' => $car->color,
            'current_service_mileage' => $car->current_service_mileage,
            'next_service_mileage' => $car->next_service_mileage,
            'engine_type' => $car->engine_type,
            'engine_capacity' => $car->engine_capacity,
            'customer' => $car->contact->name,
            'phone_number' => $car->contact->phone,
            'services' => $car->services,
        ];
    }
}
