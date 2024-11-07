<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use Exception;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function __invoke()
    {
        try {

            $basket = auth()->user()->userData->basket->products;

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: $basket
            );
        } catch (Exception $e) {
            echo $e;
        }
    }
}
