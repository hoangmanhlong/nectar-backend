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

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const KEYWORD = 'keyword';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::THUMBNAIL_ID,
        'pivot'
    ];

    public static function getProducts()
    {
        try {
            return self::all()->map(function ($product) {
                return self::convertProductImage($product);
            });
        } catch (Exception) {
            return [];
        }
    }

    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class, ProductImage::PRODUCT_ID, self::ID);
    }

    public static function getProductById(int $id, bool $isAuth)
    {
        try {
            //findOrFail(): Phương thức này sẽ ném ra một ngoại lệ ModelNotFoundException nếu
            // không tìm thấy bản ghi, hữu ích trong trường hợp bạn muốn xử lý lỗi khi id không tồn tại.
            $product = self::findOrFail($id);
            $product = self::convertProductImage($product);
            if (!$isAuth) $product->is_favorite = null;
            return $product;
        } catch (Exception) {
            return null;
        }
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(
            related: UserData::class,
            table: FavoriteProduct::TABLE_NAME,
            foreignPivotKey: self::ID,
            relatedPivotKey: FavoriteProduct::USER_ID
        );
    }

    public static function convertProductImage(Product $product)
    {
        $product->thumbnail = $product->thumbnail;
        $product->thumbnail->image_url = AppUtils::getImageUrlAttribute($product->thumbnail->image_url);
        $product->images = [
            $product->thumbnail,
            $product->thumbnail,
            $product->thumbnail
        ];
        return $product;
    }

    public static function searchProduct(mixed $keyword) {
        try {
            return self::query()->where(
                column: self::NAME,
                operator: 'LIKE',
                value: '%' . $keyword . '%'
            )->get()->map(function ($product) {
                return self::convertProductImage($product);
            });
        } catch(Exception) {
            return [];
        }
    }
}
