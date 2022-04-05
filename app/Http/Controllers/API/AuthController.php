<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), self::$rules);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->all(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseBuilder::success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], "Register success");
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return ResponseBuilder::error('Invalid credentials', 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseBuilder::success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], "Login success");
    }

    public function logout()
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return ResponseBuilder::success(null, "Logout success");
    }

}