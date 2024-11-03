<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

/**
 * Before running this seeder make sure you have run ProductCategoryImageSeeder or have data in the product_categories table
 * and migrate php artisan migrate --path=database/migrations/2020_example_table.php
 * 
 * command: php artisan db:seed --class=ProductCategoriesSeeder
 */
class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                ProductCategory::NAME => 'Frash Fruits & Vegetable',
                ProductCategory::COLOR => '53B175',
                ProductCategory::CATEGORY_IMAGE_ID => 1
            ],
            [
                ProductCategory::NAME => 'Cooking Oil & Ghee',
                ProductCategory::COLOR => 'F8A44C',
                ProductCategory::CATEGORY_IMAGE_ID => 2
            ],
            [
                ProductCategory::NAME => 'Meat & Fish',
                ProductCategory::COLOR => 'F7A593',
                ProductCategory::CATEGORY_IMAGE_ID => 3
            ],
            [
                ProductCategory::NAME => 'Bakery & Snacks',
                ProductCategory::COLOR => 'D3B0E0',
                ProductCategory::CATEGORY_IMAGE_ID => 4
            ],
            [
                ProductCategory::NAME => 'Dairy & Eggs',
                ProductCategory::COLOR => 'FDE598',
                ProductCategory::CATEGORY_IMAGE_ID => 5
            ],
            [
                ProductCategory::NAME => 'Beverages',
                ProductCategory::COLOR => 'B7DFF5',
                ProductCategory::CATEGORY_IMAGE_ID => 6
            ],
        ];

        foreach($categories as $categoryItem) {
            $category = new ProductCategory;
            $category->name = $categoryItem[ProductCategory::NAME];
            $category->color = $categoryItem[ProductCategory::COLOR];
            $category->category_image_id = $categoryItem[ProductCategory::CATEGORY_IMAGE_ID];

            $category->save();
        }
    }
}
