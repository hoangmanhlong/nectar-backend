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
        BasketItem::QUANTITY => ['required', 'integer', 'min:1'],
        'method' => ['required', 'integer', 'in:0,1'],
    ];

    private $addNewProductsInBasketBodyRequestDataRules = [
        'products' => ['required', 'array'],
        'products.*.' . BasketItem::ID => ['required', 'integer'],
        'products.*.' . BasketItem::QUANTITY => ['required', 'integer', 'min:1'],
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
                return Product::convertProductImage($product);
            });

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: [
                    'total_items' => $totalItems,
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

            // Kiểm tra xem sản phẩm có hay chưa. nếu có thì cộng dồn. nếu chưa thì thêm mới
            // và lấy số lượng từ request

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

            $products = $params['products'];

            foreach ($products as $product) {
                $basket->products()->create([
                    BasketItem::PRODUCT_ID => $product[Product::ID],
                    BasketItem::QUANTITY => 1
                ]);
            }

            DB::commit();

            // trả về số sản phẩm trong giỏ

            return $this->__invoke();
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
        } catch (Exception) {
        }
    }

    public function delete(Request $request)
    {
        try {
            $params  = $request->all();
            $productId = $params[Product::ID];
            $userData = auth()->user()->userData;
            $basket = $userData->basket;
            $deleted = $basket->products()->where(BasketItem::PRODUCT_ID, $productId)->delete();

            if ($deleted) {
                return AppResponse::success(
                    status: AppResponse::SUCCESS_STATUS,
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
