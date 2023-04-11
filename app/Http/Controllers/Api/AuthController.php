<?php

namespace App\Http\Controllers\Api;
use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterUser;
class AuthController extends Controller
{
    /**
     * Create the customer
     * @param array| $request
     * return json
     */
    public function createUser(RegisterUser $request) : JsonResponse {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("LaravelToken")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The Customer
     * @param Request $request
     * @return User
     */
    public function loginUser(LoginRequest $request) : JsonResponse {
        try {
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("LaravelToken")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
