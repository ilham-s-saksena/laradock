<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "err",
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $reg = $this->authService->register($request->all());

        if ($reg) {
            return response()->json([
                'message' => 'User registered successfully'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to register user'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $log = $this->authService->login($credentials);
        return $log;
    }
}
