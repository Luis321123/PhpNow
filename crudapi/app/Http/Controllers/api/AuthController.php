<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    { $Validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8']
            ,['email.unique' => 'User with this email already exists']);

            if ($Validator->fails()) {
                return response()->json([
                    'message' => $Validator->errors(),
                    'status' => 422,
                ], 422);
            }
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            $token = $users->createToken('auth_token')->plainTextToken;
            
            return response()
            ->json(['data' => $users,'access_token' => $token, 'token_type' => 'Bearer']);
        }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
            ->json(['message' => 'Unauthorized'], 401);
        }
            $users = User::where('email', $request->email)->first();

            $token = $users->createToken('auth_token')->plainTextToken;
    
            return response()
            ->json([
                'message' => 'Hi '.$users->name,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $users
            ]);
        }

    public function logout(Request $request)
    {
        if (!$request->header('Authorization')) {
            return response()->json([
                'message' => 'Authorization token is missing.',
                'status' => 401,
            ], 401);
        }

        if (!$request->user()) {
            return response()->json([
                'message' => 'Invalid or expired token.',
                'status' => 401,
            ], 401);
        }

        $user = $request->user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful. Tokens have been deleted.',
            'status' => 200,
        ], 200);
    }
    public function getActiveTokens(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'status' => 401,
            ], 401);
        }

        $tokens = $user->tokens;

        return response()->json([
            'message' => 'Active tokens retrieved successfully.',
            'status' => 200,
            'tokens' => $tokens,
        ], 200);
    }
}