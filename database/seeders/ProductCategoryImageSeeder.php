<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductCategoryImage;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductCategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get list all files in banner folder
        $images = Storage::disk('public')->allFiles(ProductCategory::TABLE_NAME);


        foreach($images as $image) {
            $productCategoryImage = new ProductCategoryImage;

            // Get file name (without path)
            $fileName = basename($image);

            $productCategoryImage->title = ucfirst(pathinfo($fileName, PATHINFO_FILENAME));
            $productCategoryImage->image_url = Storage::url($image);

            $productCategoryImage->save();

        }
    }
}
