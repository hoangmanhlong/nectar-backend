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

            $basket = auth()->user()->userData->basket;

            if(!$basket) {
                return AppResponse::success(
                    status: AppResponse::SUCCESS_STATUS,
                    data: []
                );
            }

            $productsInBasket = $basket->products;

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: $productsInBasket
            );
        } catch (Exception $e) {
            echo $e;
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function updateBasket(Request $request) {

    }
}
