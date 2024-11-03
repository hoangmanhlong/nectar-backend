<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const TABLE_NAME = 'products';

    const ID = 'id'; // Integer

    const NAME = 'name'; // String

    const DESCRIPTION = 'description'; // String

    const UNIT_OF_MEASURE = 'unit_of_measure'; // String

    const PRICE = 'price'; // Double
    
    const NUTRIENTS = 'nutrients'; // String

    const RATING = 'rating'; // Integer

    const STOCK = 'stock'; // Integer

    const CATEGORY_ID = 'category_id'; // Integer

    const SOLD = 'sold'; // Integer

    const THUMBNAIL_ID = 'thumbnail_id'; // Integer

    protected $table = self::TABLE_NAME;

    public static function getProducts() {
        try {
            return self::all();
        } catch(Exception) {
            return [];
        }
    }
}
