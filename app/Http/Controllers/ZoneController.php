<?php

namespace App\Http\Controllers;

use App\Models\AppResponse;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;

class ZoneController extends Controller
{

    function __invoke(): JsonResponse
    {
        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: Zone::getZones()
        );
    }
}
