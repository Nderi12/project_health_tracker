<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function customers()
    {
        $customers = Customer::where('type', 'customer')->paginate(env('PER_PAGE', 10));

        return response()->json([
            'customers' => $customers,
            'page_links' => $customers->toArray()['links']
        ]);
    }

    public function businesses()
    {
        $businesses = Customer::where('type', 'business')->paginate(env('PER_PAGE', 10));

        return response()->json([
            'businesses' => $businesses,
            'page_links' => $businesses->toArray()['links']
        ]);
    }

    public function suppliers()
    {
        $suppliers = Contact::where('type', 'supplier')->paginate(env('PER_PAGE', 10));

        return response()->json([
            'suppliers' => $suppliers,
            'page_links' => $suppliers->toArray()['links']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function() use($request){
            // Create customer
            $customer = Customer::create($request->all());          
        });

        return response()->json([
            'message' => 'Customer created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Contact::where('id', $id)->with(['cars'])->first();

        return response()->json([
            'customer' => $customer
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}