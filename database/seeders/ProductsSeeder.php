<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                Product::NAME => 'Organic Apple',
                Product::DESCRIPTION => 'Fresh organic apples grown without pesticides.',
                Product::UNIT_OF_MEASURE => 'kg',
                Product::PRICE => 3.99,
                Product::NUTRIENTS => 'Vitamin C, Fiber',
                Product::RATING => 5,
                Product::STOCK => 150,
                Product::CATEGORY_ID => 1,
                Product::SOLD => 30,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Banana',
                Product::DESCRIPTION => 'Sweet and ripe bananas, perfect for a healthy snack.',
                Product::UNIT_OF_MEASURE => 'dozen',
                Product::PRICE => 2.50,
                Product::NUTRIENTS => 'Potassium, Vitamin B6',
                Product::RATING => 4,
                Product::STOCK => 200,
                Product::CATEGORY_ID => 1,
                Product::SOLD => 50,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Bell pepper red',
                Product::DESCRIPTION => 'Dairy-free almond milk with a smooth, creamy taste.',
                Product::UNIT_OF_MEASURE => 'liter',
                Product::PRICE => 3.20,
                Product::NUTRIENTS => 'Vitamin E, Calcium',
                Product::RATING => 4,
                Product::STOCK => 75,
                Product::CATEGORY_ID => 1,
                Product::SOLD => 15,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Ginger',
                Product::DESCRIPTION => 'Organic brown rice rich in fiber and nutrients.',
                Product::UNIT_OF_MEASURE => 'kg',
                Product::PRICE => 1.80,
                Product::NUTRIENTS => 'Fiber, Magnesium',
                Product::RATING => 5,
                Product::STOCK => 300,
                Product::CATEGORY_ID => 1,
                Product::SOLD => 100,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Egg noodles',
                Product::DESCRIPTION => 'Fresh avocados packed with healthy fats and fiber.',
                Product::UNIT_OF_MEASURE => 'each',
                Product::PRICE => 1.50,
                Product::NUTRIENTS => 'Healthy Fats, Fiber',
                Product::RATING => 5,
                Product::STOCK => 50,
                Product::CATEGORY_ID => 2,
                Product::SOLD => 20,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Egg noodles',
                Product::DESCRIPTION => 'Fresh green broccoli full of vitamins and minerals.',
                Product::UNIT_OF_MEASURE => 'kg',
                Product::PRICE => 2.00,
                Product::NUTRIENTS => 'Vitamin K, Vitamin C',
                Product::RATING => 4,
                Product::STOCK => 80,
                Product::CATEGORY_ID => 2,
                Product::SOLD => 35,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Egg pasta',
                Product::DESCRIPTION => 'Nutrient-dense chia seeds perfect for smoothies and baking.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 4.50,
                Product::NUTRIENTS => 'Omega-3, Fiber',
                Product::RATING => 5,
                Product::STOCK => 100,
                Product::CATEGORY_ID => 2,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Mayonnais Eggless',
                Product::DESCRIPTION => 'High-protein Greek yogurt with a creamy texture.',
                Product::UNIT_OF_MEASURE => 'cup',
                Product::PRICE => 1.20,
                Product::NUTRIENTS => 'Protein, Calcium',
                Product::RATING => 5,
                Product::STOCK => 150,
                Product::CATEGORY_ID => 2,
                Product::SOLD => 75,
                Product::THUMBNAIL_ID => 2,
            ],
            [
                Product::NAME => 'Beef bone',
                Product::DESCRIPTION => 'High-protein quinoa that serves as a versatile grain alternative.',
                Product::UNIT_OF_MEASURE => 'kg',
                Product::PRICE => 5.00,
                Product::NUTRIENTS => 'Protein, Fiber',
                Product::RATING => 4,
                Product::STOCK => 60,
                Product::CATEGORY_ID => 3,
                Product::SOLD => 25,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Broiler chicken',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 3,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Egg chicken fresh',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 5,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Egg chicken packet',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 5,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Apple juice',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Coca cola',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Diet coke',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Orenge juice',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Pepsi',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
            [
                Product::NAME => 'Sprite',
                Product::DESCRIPTION => 'Fresh, antioxidant-rich blueberries.',
                Product::UNIT_OF_MEASURE => 'pack',
                Product::PRICE => 3.00,
                Product::NUTRIENTS => 'Vitamin C, Fiber, Antioxidants',
                Product::RATING => 5,
                Product::STOCK => 90,
                Product::CATEGORY_ID => 6,
                Product::SOLD => 40,
                Product::THUMBNAIL_ID => 1,
            ],
        ];

        foreach($products as $productItem) {
            $product = new Product;

            $product->name = $productItem[Product::NAME];
            $product->description = $productItem[Product::DESCRIPTION];
            $product->unit_of_measure = $productItem[Product::UNIT_OF_MEASURE];
            $product->price = $productItem[Product::PRICE];
            $product->nutrients = $productItem[Product::NUTRIENTS];
            $product->rating = $productItem[Product::RATING];
            $product->stock = $productItem[Product::STOCK];
            $product->category_id = $productItem[Product::CATEGORY_ID];
            $product->thumbnail_id = $productItem[Product::THUMBNAIL_ID];
            $product->sold = $productItem[Product::SOLD];

            $product->save();
        }
        
    }
}
