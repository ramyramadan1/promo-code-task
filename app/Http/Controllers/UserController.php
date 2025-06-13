<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    
     /**
     * Authenticate user and return token
     * Handle an authentication attempt.
     */

    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) { 
            $token  = $this->createToken();
            return response()->json(['message' => '','token' => $token]);
        }
        return response()->json(['The provided credentials do not match our records.']);
    }
    
    /**
     * Create user token
     * @param type $param
     * @return type
     */
    public function createToken() {
        $user = Auth::user();
        return $user->createToken('token-name')->plainTextToken;
    }
}
