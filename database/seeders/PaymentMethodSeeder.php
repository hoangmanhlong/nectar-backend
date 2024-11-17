<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PaymentMethodSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get list all files in banner folder
        $images = Storage::disk('public')->allFiles('payment_methods');

        $i = 1;

        foreach ($images as $image) {

            // Get file name (without path)
            $fileName = basename($image);

            // Create a new banner instance
            $paymentMethod = new PaymentMethod();
            $paymentMethod->name = ucfirst(pathinfo($fileName, PATHINFO_FILENAME));
            $paymentMethod->code = $i;
            $paymentMethod->image_url = Storage::url($image);

            $paymentMethod->save();
            $i++;
        }
    }
}
