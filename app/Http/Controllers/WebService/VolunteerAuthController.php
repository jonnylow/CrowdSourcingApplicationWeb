<?php

namespace App\Http\Controllers\WebService;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;

class VolunteerAuthController extends Controller
{
    public function __construct()
   {
       // Set the Eloquent model that should be used to retrieve your users
       Config::set('auth.model', 'App\Volunteer');

       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       Config::set('auth.model', 'App\Volunteer');
       $this->middleware('jwt.auth', 'jwt.refresh', ['except' => ['authenticate']]);
   }

   /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token']);
        }

        // get user's detail to include with returning token
        $authenticatedUser = JWTAuth::setToken($token)->authenticate()->toArray();
        $user = array_only($authenticatedUser, ['volunteer_id', 'name', 'email', 'is_approved']);

        // all good so return the token
        return response()->json(compact('token', 'user'));
    }

    // Retrieving the Authenticated user from a token
    // which will automatically get the token from the request
    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
