<?php

namespace App\Http\Controllers;

use App\Models\AppResponse;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: Banner::getBanners()
        );
    }
}
