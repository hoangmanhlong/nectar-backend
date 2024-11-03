<?php

namespace App\Models;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AppResponse
{

    const STATUS = 'status';
    const MESSAGE = 'message';
    const DATA = 'data';

    const SUCCESS_STATUS = 1;
    const ERROR_STATUS = 0;

    public static function response(int $status = null, string $message = null, mixed $data = null): array
    {
        return [
            self::STATUS => $status,
            self::MESSAGE => $message,
            self::DATA => $data
        ];
    }

    public static function success(
        int    $status = null,
        string $message = null,
        mixed  $data = null
    ): JsonResponse
    {
        return response()->json(self::response($status, $message, $data), Response::HTTP_OK);
    }

    public static function error(
        string $message = null,
        mixed  $data = null
    ): JsonResponse
    {
        return response()->json(self::response(self::ERROR_STATUS, $message, $data), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function unknownError(string $message = null, mixed $data = null): JsonResponse
    {
        return response()->json(
            data: self::response(self::ERROR_STATUS, $message, $data),
            status: Response::HTTP_BAD_REQUEST
        );
    }

    public static function unauthorized(): JsonResponse
    {
        return response()->json(
            self::response(
                status: self::ERROR_STATUS,
                message: __(key: 'messages.unauthorized')
            ),
            status: Response::HTTP_UNAUTHORIZED
        );
    }

    public static function invalidRequestBodyContent(): JsonResponse
    {
        return response()->json(
            data: self::response(
                status: Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
                message: __(key: 'message.unauthorized')
            ),
            status: Response::HTTP_UNSUPPORTED_MEDIA_TYPE
        );
    }

    public static function invalidRuleParams(): JsonResponse
    {
        return response()->json(
            data: self::response(
                status: self::ERROR_STATUS,
                message: __(key: 'messages.invalid_request_parameter_validation')
            ),
            status: Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
