<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\Product;
use App\Models\ProductGroup;

class ProductController extends Controller
{
    function __invoke()
    {
        $products = Product::getProducts();

        if ($products->isEmpty()) {
            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: []
            );
        }

        // Group 1: Recommend for you (10 random products)
        $productsArray = $products->toArray();
        $recommendedProductKeys = array_rand($productsArray, 10);
        $recommendedProducts = array_map(fn($key) => $productsArray[$key], $recommendedProductKeys);
        $group1 = new ProductGroup(1, 'Recommend for you', $recommendedProducts);

        // Group 3: Các sản phẩm thuộc category = 6
        $productsArray = $products->toArray();
        $productsOfCategory6 = array_filter($productsArray, function ($product) {
            return $product['category_id'] == 6;
        });

        $group3 = new ProductGroup(3, 'Discovery', array_values($productsOfCategory6));

        $productgroups = [
            [
                'id' => $group1->id,
                'name' => $group1->name,
                'products' => $group1->products
            ],
            [
                'id' => $group3->id,
                'name' => $group3->name,
                'products' => $group3->products
            ],

        ];

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: $productgroups
        );
    }


    public function getProductById(int $productId)
    {
        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: Product::getProductById($productId)
        );
    }
}
