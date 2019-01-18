<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;


class AuthController extends Controller {

  
    /**
     * Register new user
     * 
     * @param []
     */
    public function register(Request $request) {

    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     */
    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->username,
            'password' => $request->password
        ]);


        $tokenRequest = Request::create(config('services.passport.login_endpoint'),
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