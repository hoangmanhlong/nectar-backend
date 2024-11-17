<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatus = [
            'Processing',
            'Completed',
            'Return',
            'Cancel'
        ];

        foreach($orderStatus as $statusName) {
            $status = new OrderStatus();
            $status->name = $statusName;
            $status->save();
        }
    }
}
