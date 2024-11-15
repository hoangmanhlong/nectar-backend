<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\AppUtils;
use App\Models\BasketItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{

    private $updateBasketItemDataRules = [
        Product::ID => ['required'],
        BasketItem::QUANTITY => ['required', 'integer', 'min:2'],
        'method' => ['required', 'integer', 'in:0,1'],
    ];

    private $addNewProductsInBasketBodyRequestDataRules = [
        '*' => ['bail', 'required', 'array', 'min:1'], // bail: Dừng kiểm tra các rule còn lại nếu một rule trước đó không đạt.
        '*.id' => ['required', 'integer'],
        '*.quantity' => ['required', 'integer', 'min:1'],
    ];

    public function __invoke()
    {
        try {

            $basket = auth()->user()->userData->basket;

            if (!$basket) {
                return AppResponse::success(
                    status: AppResponse::SUCCESS_STATUS,
                    data: []
                );
            }

            $totalItems = 0;
            $totalPrice = 0.0;

            $productsInBasket = $basket->products->map(function ($basketItem) use (&$totalPrice, &$totalItems) {
                $product = $basketItem->product;
                $product->quantity = $basketItem->quantity;
                $totalPrice += $product->price * $basketItem->quantity;
                $totalItems++;
                return Product::getAdditionalProductInformation($product);
            });

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: [
                    'total_product' => $totalItems,
                    'total_price' => $totalPrice,
                    'products' => $productsInBasket
                ]
            );
        } catch (Exception) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {

            $params = $request->all();

            if ($params === null || !is_array($params) || empty($params)) {
                return AppResponse::invalidRuleParams();
            }

            $validationResponse = AppUtils::validateParamsWithRule(
                params: $params,
                rule: $this->addNewProductsInBasketBodyRequestDataRules
            );

            if ($validationResponse) {
                DB::commit();
                return $validationResponse;
            }

            $userData = auth()->user()->userData;
            $basket = $userData->basket;

            if (!$basket) {
                $basket = $userData->basket()->create();
            }

            $products = $params;

            foreach ($products as $product) {
                $existingProduct = $basket->products()
                    ->where(BasketItem::PRODUCT_ID, $product[Product::ID])
                    ->first();

                if ($existingProduct) {
                    $existingProduct->increment(BasketItem::QUANTITY, $product[BasketItem::QUANTITY]);
                } else {
                    $basket->products()->create([
                        BasketItem::PRODUCT_ID => $product[Product::ID],
                        BasketItem::QUANTITY => $product[BasketItem::QUANTITY],
                    ]);
                }
            }

            DB::commit();

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: [
                    'total_product' => $basket->products()->count()
                ]
            );
        } catch (Exception) {
            DB::rollBack();
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function update(Request $request)
    {
        try {
            $params = $request->all();

            $validationResponse = AppUtils::validateParamsWithRule($params, $this->updateBasketItemDataRules);
            if ($validationResponse) return $validationResponse;

            // Convention
            // 'method': 0 is decrease quantity, 1 is increase quantity
            $method = $params['method'];
            $productId = $params[Product::ID];
            $quantity = $params[BasketItem::QUANTITY];

            $userData = auth()->user()->userData;
            $basket = $userData->basket;

            if ($basket === null || empty($basket)) {
                return AppResponse::success(
                    status: AppResponse::ERROR_STATUS
                );
            }

            // Adjust quantity based on the method
            $quantity = $method === 0 ? $quantity - 1 : $quantity + 1;

            // Get updated product
            $updatedProduct = $basket->products()->where(BasketItem::PRODUCT_ID, $productId);

            // Update the product quantity in the basket
            $updatedProduct->update([BasketItem::QUANTITY => $quantity]);

            $totalItems = 0;
            $totalPrice = 0.0;

            $basket->products->map(function ($basketItem) use (&$totalPrice, &$totalItems) {
                $product = $basketItem->product;
                $product->quantity = $basketItem->quantity;
                $totalPrice += $product->price * $basketItem->quantity;
                $totalItems++;
            });

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: [
                    'total_product' => $totalItems,
                    'total_price' => $totalPrice,
                    'product' => [
                        Product::ID => $productId,
                        BasketItem::QUANTITY => $quantity
                    ]
                ]
            );
        } catch (Exception $e) {
            echo $e;
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function delete(Request $request)
    {
        try {
            $params  = $request->all();
            $productId = $params[Product::ID];
            $userData = auth()->user()->userData;
            $basket = $userData->basket;
            $deletedProduct = $basket->products()->where(BasketItem::PRODUCT_ID, $productId);

            if (!$deletedProduct) {
                return AppResponse::success(
                    status: AppResponse::ERROR_STATUS
                );
            }

            $deleted = $deletedProduct->delete();

            if ($deleted) {

                $totalItems = 0;
                $totalPrice = 0.0;

                $basket->products->map(function ($basketItem) use (&$totalPrice, &$totalItems) {
                    $product = $basketItem->product;
                    $product->quantity = $basketItem->quantity;
                    $totalPrice += $product->price * $basketItem->quantity;
                    $totalItems++;
                });

                return AppResponse::success(
                    status: AppResponse::SUCCESS_STATUS,
                    data: [
                        'total_product' => $totalItems,
                        'total_price' => $totalPrice,
                        'product' => [
                            Product::ID => $productId
                        ]
                    ]
                );
            } else {
                return AppResponse::success(
                    status: AppResponse::ERROR_STATUS,
                    message: 'Product not found in basket'
                );
            }
        } catch (Exception) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }
}
