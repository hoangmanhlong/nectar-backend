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

    const REVIEW = 'review'; // Float - General reviews of people about the product

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

    public static function getProductById(int $id)
    {
        try {
            //findOrFail(): Phương thức này sẽ ném ra một ngoại lệ ModelNotFoundException nếu
            // không tìm thấy bản ghi, hữu ích trong trường hợp bạn muốn xử lý lỗi khi id không tồn tại.
            $product = self::findOrFail($id);
            return self::convertProductImage($product);
        } catch (Exception) {
            return null;
        }
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(
            related: UserData::class,
            table: FavoriteProduct::TABLE_NAME,
            foreignPivotKey: FavoriteProduct::PRODUCT_ID,
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

    public function basketItem()
    {
        return $this->belongsTo(BasketItem::class, BasketItem::PRODUCT_ID, self::ID);
    }

    public function ratings() {
        return $this->belongsToMany(
            related: UserData::class,
            table: ProductRating::TABLE_NAME,
            foreignPivotKey: ProductRating::PRODUCT_ID,
            relatedPivotKey: ProductRating::USER_ID
        );
    }
}
