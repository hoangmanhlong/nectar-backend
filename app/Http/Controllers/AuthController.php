<?php

namespace App\Http\Controllers;

use App\Models\AppResponse;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        if (! $token = $this->getToken()) {
            return AppResponse::unauthorized();
        }

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            message: __(key: 'messages.login_success'),
            data: ['token' => $token]
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(AppResponse::response(200, 'Successfully logged out'));
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get token of current user
     *
     * @return string
     */

    protected function getToken(): string {
        $credentials = request([UserAccount::EMAIL, UserAccount::PASSWORD]);
        return auth()->attempt($credentials);
    }
}
