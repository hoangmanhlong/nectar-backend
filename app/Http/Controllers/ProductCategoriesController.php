<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    public function __invoke() 
    {
        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: ProductCategory::getAllProductCategories()
        );
    }
}
