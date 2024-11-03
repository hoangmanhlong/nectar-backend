<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryImage extends Model
{
    const TABLE_NAME = 'categories_images';

    const ID = 'id';
    const TITLE = 'title';
    const IMAGE_URL = 'image_url';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function productCategory() {
        return $this->belongsTo(ProductCategory::class, ProductCategory::ID, self::ID);
    }
}
