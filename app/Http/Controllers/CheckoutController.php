<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\AppUtils;
use App\Models\Order;
use App\Models\OrderProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    private $checkoutBodyDataRule = [
        'delivery' => ['required', 'integer', 'in:1,2,3'],
        'payment' => ['required', 'integer', 'min:1', 'max:10'],
    ];

    public function checkout(Request $request) {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $isRequestBodyDataInvalid = AppUtils::validateParamsWithRule($params, $this->checkoutBodyDataRule);
            if($isRequestBodyDataInvalid) return $isRequestBodyDataInvalid;

            $userData = AppUtils::getUserData();

            $deliveryId = $params['delivery'];
            $paymentMethodId = $params['payment'];

            $basket = $userData->basket;

            if($basket === null || empty($basket)) throw new Exception();

            $basketProducts = $basket->products;

            if($basketProducts === null || empty($basketProducts)) throw new Exception();

            $order = $userData->orders()->create([
                Order::DELIVERY_METHOD_ID => $deliveryId,
                Order::PAYMENT_METHOD_ID => $paymentMethodId,
                Order::ORDER_STATUS_ID => 1
            ]);

            foreach($basketProducts as $item) {
                $order->orderProducts()->create([
                    OrderProduct::PRODUCT_ID => $item->product_id,
                    OrderProduct::QUANTITY => $item->quantity,
                ]);
            }

            $userData->basket()->delete();

            DB::commit();

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS
            );

        } catch(Exception) {
            DB::rollBack();
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }
}
