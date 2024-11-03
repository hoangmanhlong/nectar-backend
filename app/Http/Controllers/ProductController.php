<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\Product;

class ProductController extends Controller
{
    function __invoke()
    {
        $products = Product::getProducts();

        if(empty($products)) {

        }
    }

    public function getProductById(int $productId) {
        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS
        );
    }
}
