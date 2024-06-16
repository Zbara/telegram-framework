<?php

namespace App\Admin\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\Auth\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected array $abilities = [
        0 => ['*'],
        1 => ['admin'],
        2 => ['support'],
    ];

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function loginForm(
        LoginRequest $request
    ): JsonResponse
    {
        if (Auth::guard('api')->attempt($request->only('email', 'password'))) {
            $user =  Auth::guard('api')->user();

            $generateToken = $user->createToken('authToken', ['*'], now()->addDays(7));

            if(isset($generateToken->plainTextToken)){
                return \response()->json([
                    'access_token' => $generateToken->plainTextToken,
                    'expires_at' => Carbon::parse($generateToken->accessToken->expires_at)->unix(),
                    'username' => $user->email,
                    'role' => 0
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'messages' => 'Неверный email или пароль.'
        ], Response::HTTP_UNAUTHORIZED);
    }



    /**
     * Logout and remove token
     *
     * @param Request $request
     * @return void
     */
    public function logout(
        Request $request
    ): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function getSession(
        Request $request
    ): JsonResponse
    {
        if ($request->user()) {
            return response()->json(['valid' => true]);
        }
        return response()->json(['valid' => false], Response::HTTP_UNAUTHORIZED);
    }

    public function refreshToken(
        Request $request
    ): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function getUser(
        Request $request
    ){
        return UserResource::make(
            User::find(\auth()->id())
        );
    }
}
