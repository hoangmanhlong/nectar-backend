<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserAccount;

class UserAccountController extends Controller {

    private $loginDataRule = [
        UserAccount::EMAIL => ['required', 'email', 'string'],
        UserAccount::PASSWORD => ['required', 'string']
    ];

    private $changePasswordRule = [
        UserAccount::EMAIL => ['required', 'email', 'string'],
        UserAccount::PASSWORD => ['required', 'string'],
        UserAccount::NEW_PASSWORD => ['required', 'string'],
    ];

    function login(Request $request) {

        $params = $request->all();

        $validator = Validator::make($params, $this->loginDataRule);

        if($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Request data invalid']);
        }

        $loginResult = UserAccount::login(
            $params[UserAccount::EMAIL],
             $params[UserAccount::PASSWORD]
        );

        return response()->json([
            'status' => $loginResult ? 200 : 500,
            'message' => $loginResult ? 'Success' : 'Invalid'
        ]);
    }

    function register(Request $request) {
        $params = $request->all();

        $validator = Validator::make($params, $this->loginDataRule);

        if($validator->fails()) {
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

    function changePassword(Request $request) {
        $params = $request->all();

        $validator = Validator::make($params, $this->changePasswordRule);

        if($validator->fails()) {
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