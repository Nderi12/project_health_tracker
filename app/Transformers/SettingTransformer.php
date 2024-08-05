<?php

namespace App\Transformers;

use App\Models\Setting;
use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
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
    public function transform(Setting $setting)
    {
        return [
            'id' => $setting->id,
            'key' => $setting->key,
            'type' => $setting->type,
            'name' => $setting->name,
            'values' => $setting->values,
            'description' => $setting->description,
        ];
    }
}
