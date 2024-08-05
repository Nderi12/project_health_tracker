<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SettingValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $settingValues = SettingValue::all();

        return response()->json([
            'settingValues' => $settingValues
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $setting = Setting::where('id', $request->setting_id)->first();

        DB::transaction(function() use ($request, $setting){
            $value = $setting->values()->create($request->all());
        });

        //  Redirect to the previous page and flash a message
        return response()->json([
            'message' => 'Setting value created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $settingValues = SettingValue::where('setting_id', $id)->get();

        return response()->json([
            'settingValues' => $settingValues
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SettingValue $settingValue)
    {
        //
    }
}
