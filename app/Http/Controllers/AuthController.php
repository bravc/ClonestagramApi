<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;


class AuthController extends Controller {

  
    /**
     * Register new user
     * 
     * @param [name]
     */
    public function register(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Login user and create token
     *
     * @param  [string] username
     * @param  [string] password
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password
        ]);


        $tokenRequest = Request::create(env('APP_URL').'/oauth/token',
            'POST'
        );
        $response = Route::dispatch($tokenRequest);


        return $response;
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}