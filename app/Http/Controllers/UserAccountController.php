<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\Success;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserAccount;

class UserAccountController extends Controller
{

    private $loginDataRule = [
        UserAccount::EMAIL => ['required', 'email', 'string'],
        UserAccount::PASSWORD => ['required', 'string']
    ];

    private $changePasswordRule = [
        UserAccount::EMAIL => ['required', 'email', 'string'],
        UserAccount::PASSWORD => ['required', 'string'],
        UserAccount::NEW_PASSWORD => ['required', 'string'],
    ];

    function login(Request $request): JsonResponse
    {

        $params = $request->all();

        $validator = Validator::make($params, $this->loginDataRule);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()
            ]);
        }

        $loginResult = UserAccount::login(
            $params[UserAccount::EMAIL],
            $params[UserAccount::PASSWORD]
        );

        if ($loginResult instanceof Success) {
            return response()->json([
                'status' => 200,
                'message' => 'Login success',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => ($loginResult instanceof Error) ? $loginResult->exception->getMessage() : ''
        ]);
    }

    function register(Request $request): JsonResponse
    {
        $params = $request->all();

        $validator = Validator::make($params, $this->loginDataRule);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Request data invalid']);
        }

        $registerResult = UserAccount::register(
            $params[UserAccount::EMAIL],
            $params[UserAccount::PASSWORD]
        );

        return response()->json([
            'status' => $registerResult ? 200 : 500,
            'message' => $registerResult ? 'Success' : 'Invalid'
        ]);
    }

    function changePassword(Request $request): JsonResponse
    {
        $params = $request->all();

        $validator = Validator::make($params, $this->changePasswordRule);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Request data invalid']);
        }

        $changePassword = UserAccount::changePassword(
            $params[UserAccount::EMAIL],
            $params[UserAccount::PASSWORD],
            $params[UserAccount::NEW_PASSWORD]
        );

        return response()->json([
            'status' => $changePassword ? 200 : 500,
            'message' => $changePassword ? 'Success' : 'Invalid'
        ]);
    }
}
