<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function logout_session(Request $request){
        return response()->json([
            'status' => $request->session()->get('csrf_token'),
            'message' => 'User is logged out successfully'
            ], 200);
    }
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();
        // Generate the token for the user
        $token = $user->createToken('token')->plainTextToken;
        // $request->session()->put('csrf_token', $token);
        Session::put('token', $token);
        // Create the response
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'token'=> session('token'),
            // 'token' => $request->session()->get('csrf_token'),
            'user' => $user  // Optional: Include user data in the response
        ];

        return response()->json($response, 200);
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $request()->user()->tokens()->delete();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'User is logged out successfully'
        //     ], 200);
    }
}
