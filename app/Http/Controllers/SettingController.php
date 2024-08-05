<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all();

        return response()->json([
            'settings' => $settings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function() use ($request){

            //create the key from name of setting
            $key = Str::slug($request->name);

            //  create the setting
            Setting::create([
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'key' => $key
            ]);
        });

        return response()->json([
            'message' => 'Setting created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $setting = Setting::where('id', $id)->first();

        return response()->json([
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::where('id', $id)->first();
        
        //Update the setting data
        DB::transaction(function() use ($setting, $request){
            //create the key from name of setting
            $key = Str::slug($request->name);
            
            // Update the setting
            $setting->update([
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'key' => $key
            ]);
        });

        /**
         * Once updated,
         * Return response with message and data
         */
        return response()->json([
            'message' => 'Setting updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return response()->json([
            'message' => 'Setting deleted successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function fetchByKey($key)
    {
        $setting = Setting::where('key', $key)->first();

        return response()->json([
            'setting' => $setting
        ]);
    }

    /**
     * Search through settings
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $results = Setting::where('name', 'like', '%'.$query.'%')
            ->get();
            
        return response()->json($results);
    }
}
