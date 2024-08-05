<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use App\Models\Customer;

use App\Transformers\CustomerAccessTransformer;
use App\Transformers\RiderAccessTransformer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Hash;
use Auth;
use Mail;

class AccessController extends Controller
{

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function logout()
    // {
    //     Auth::logout();
    //     return null;
    // }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function loginApi(Request $request)
    {

        $request->phone_number=Str::of($request->phone_number)->replace("+", "");
        $request->phone_number=Str::of($request->phone_number)->replace(" ", "");
        if(Str::substr($request->phone_number, 0,1)=="0" && strlen($request->phone_number)==10){ $request->phone_number="254".Str::substr($request->phone_number, 1); }
        if(Str::substr($request->phone_number, 0,1)!="0" && strlen($request->phone_number)==9){ $request->phone_number="254".$request->phone_number; }

        $request->validate([
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $user = Customer::where('phone_number', $request->phone_number)->first();
 
        if (!$user || !Hash::check($request->password, $user->password) || $user->status!=1 ) {
            throw ValidationException::withMessages(["message"=>"Login failed. The details provided are incorrect."]);
        }

        return fractal($user, new CustomerAccessTransformer($request->device_info->id ?? "timestamp_".time()));
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function riderLoginApi(Request $request)
    {

        $request->phone_number=Str::of($request->phone_number)->replace("+", "");
        $request->phone_number=Str::of($request->phone_number)->replace(" ", "");
        if(Str::substr($request->phone_number, 0,1)=="0" && strlen($request->phone_number)==10){ $request->phone_number="254".Str::substr($request->phone_number, 1); }
        if(Str::substr($request->phone_number, 0,1)!="0" && strlen($request->phone_number)==9){ $request->phone_number="254".$request->phone_number; }

        $request->validate([
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $user = Rider::where('phone_number', $request->phone_number)->first();
 
        if (!$user || !Hash::check($request->password, $user->password) || $user->status!=1 ) {
            throw ValidationException::withMessages(["message"=>"Login failed. The details provided are incorrect."]);
        }

        return fractal($user, new RiderAccessTransformer($request->device_info->id ?? "timestamp_".time()));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $response = [
            'logged_in' => Auth::check()
        ];
        return response()->json($response);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required|email:filter',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'status' => 1], $request["remember_me"])) {
            $user=auth()->user();
            if($user->agencyUser()->where('status',1)->count()==0){
                Auth::logout();
                $success = false;
                $status = 0;
                $message = __("Login failed. No match found for that combination..");
            }else{
                $success = true;
                $status = auth()->user()->email_verified_at==null ? 2 : 1;
                $message = auth()->user()->email_verified_at==null ? __("Error. Your email address is not verified.") : __("Logged in successfully.");
                $user = auth()->user();
                $user["full_name"] = $user->fullName();
            }
        } else {
            $success = false;
            $status = 0;
            $message = __("Login failed. No match found for that combination..");
        }
        $response = [
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'user' => json_decode(@$user) ?? null,
        ];
        return response()->json($response);
    }

}
