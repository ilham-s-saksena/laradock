<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register($data){

        $find = User::where('email', $data['email'])->first();
        if ($find) {
            return response()->json([
                "message"=> "err, email already exist"
            ], 403);
        }

        $new = new User();
        $new->name = $data["name"];
        $new->email = $data["email"];
        $new->password = Hash::make($data['password']);
        $sv = $new->save();

        if ($sv) {
            return response()->json([
                "message" => "ok, success refistered"
            ], 201);
        } else {
            return response()->json([
                "message"=> "err"
            ], 401);
        }
    }   
    public function login($data){

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'message' => 'invalid, wrong email or password'
            ], 401);
        }
    }
}