<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ZoneSeeder::class,
            BannerSeeder::class,
            ProductCategoryImageSeeder::class,
            ProductCategoriesSeeder::class, // Run after ProductCategoryImageSeeder
            ProductsSeeder::class
        ]);
    }
}
