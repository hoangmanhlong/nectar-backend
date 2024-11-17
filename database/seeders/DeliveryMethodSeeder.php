<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Express',
                'code' => 1
            ],
            [
                'name' => 'Fast',
                'code' => 2
            ],
            [
                'name' => 'Payment on delivery',
                'code' => 3
            ],
        ];

        foreach($datas as $data) {
            $deliveryMethod = new DeliveryMethod();

            $deliveryMethod->name = $data['name'];
            $deliveryMethod->code = $data['code'];

            $deliveryMethod->save();
        }
    }
}
