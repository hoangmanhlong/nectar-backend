<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesFolders = Storage::disk('public')->allDirectories('products');

        $i = 1;
        foreach ($categoriesFolders as $categoriesFolderItem) {
            $images = Storage::disk('public')->files($categoriesFolderItem);
            foreach ($images as $image) {
                // Get file name (without path)
                $fileName = basename($image);

                // Create a new banner instance
                $productImage = new ProductImage;
                $productImage->name = ucfirst(pathinfo($fileName, PATHINFO_FILENAME));
                $productImage->image_url = Storage::url($image);
                $productImage->product_id = $i;
                $productImage->save();
                $i++;
            }
        }
    }
}