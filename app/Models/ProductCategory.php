<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    const TABLE_NAME = 'product_categories';
    
    const ID = 'id';

    const NAME = 'name'; // String

    const COLOR = 'color'; // String

    const IMAGE = 'image';

    const CATEGORY_IMAGE_ID = 'category_image_id'; // Foreign key categories_image

    protected $fillable = [
        self::ID,
        self::NAME,
        self::COLOR,
        
    ];

    protected $hidden = [
        self::CATEGORY_IMAGE_ID,
        'created_at',
        'updated_at'
    ];

    static function getAllProductCategories() {
        try {
            return self::all()->map(function ($category) {
                $category->image = $category->image;
                $category->image->image_url = AppUtils::getImageUrlAttribute($category->image->image_url);
                return $category;
            });
        } catch(Exception) {
            return [];
        }
    }

    function image() {
        return $this->hasOne(ProductCategoryImage::class, ProductCategoryImage::ID, self::CATEGORY_IMAGE_ID);
    }
}
