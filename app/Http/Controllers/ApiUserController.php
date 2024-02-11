<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    function index(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'status' => 'Unauthorized',
                'code' => 401,
                'message' => 'These Credentials do not match our records'
            ], 401);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'status' => 'Success',
            'code' => 200,
            'message' => 'Login Success and Token Generated',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
