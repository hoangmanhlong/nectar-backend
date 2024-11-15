<?php

namespace App\Models;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AppUtils
{

    public static function validateParamsWithRule($params, $rule): ?JsonResponse
    {
        $validator = Validator::make($params, $rule);
        if ($validator->fails()) {
            return AppResponse::invalidRuleParams();
        }
        return null;
    }

    public static function getImageUrlAttribute(string $value): string
    {
        return asset($value);
    }

    public static function getUserData(): ?UserData {
        try {
            $user = auth()->user();
            return $user === null ? null : $user->userData;
        } catch(Exception) {
            return null;
        }
    }
}
