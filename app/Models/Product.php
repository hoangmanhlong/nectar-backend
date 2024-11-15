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
                return self::getAdditionalProductInformation(product: $product, canImage: true);
            });
        } catch (Exception) {
            return [];
        }
    }

    public function category()
    {
        return $this->hasOne(
            related: ProductCategory::class,
            foreignKey: ProductCategory::ID,
            localKey: self::CATEGORY_ID
        );
    }

    public static function getAdditionalProductInformation(Product $product, bool $canImage = true): Product
    {
        $product->category = $product->category;

        $review = $product->ratings()->avg(ProductRating::RATING) ?? 0;

        $isFavorite = null;

        $ratingOfMe = 0;

        if ($canImage) $product = self::convertProductImage($product);

        $userData = AppUtils::getUserData();

        if ($userData !== null) {
            $isFavorite = $userData->favoriteProducts()
                ->where(FavoriteProduct::PRODUCT_ID, $product->id)
                ->exists();

            $ratingOfMe = $userData->ratedProducts()
                ->where(ProductRating::PRODUCT_ID, $product->id)
                ->value(ProductRating::RATING) ?? 0;
        }

        $product->review = round($review, 1);
        $product->is_favorite = $isFavorite;
        $product->rating = $ratingOfMe;

        return $product;
    }

    public function thumbnail()
    {
        return $this->hasOne(
            related: ProductImage::class,
            foreignKey: ProductImage::PRODUCT_ID,
            localKey: self::ID
        );
    }

    public static function getProductById(int $productId)
    {
        try {
            //findOrFail(): Phương thức này sẽ ném ra một ngoại lệ ModelNotFoundException nếu
            // không tìm thấy bản ghi, hữu ích trong trường hợp bạn muốn xử lý lỗi khi id không tồn tại.
            $product = self::findOrFail($productId);
            return self::getAdditionalProductInformation(
                product: $product,
                canImage: true
            );
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

    public static function searchProduct(mixed $keyword)
    {
        try {
            return self::query()->where(
                column: self::NAME,
                operator: 'LIKE',
                value: '%' . $keyword . '%'
            )->get()->map(function ($product) {
                return self::getAdditionalProductInformation(product: $product, canImage: true);
            });
        } catch (Exception) {
            return [];
        }
    }

    public function basketItem()
    {
        return $this->belongsTo(BasketItem::class, BasketItem::PRODUCT_ID, self::ID);
    }

    public function ratings()
    {
        return $this->belongsToMany(
            related: UserData::class,
            table: ProductRating::TABLE_NAME,
            foreignPivotKey: ProductRating::PRODUCT_ID,
            relatedPivotKey: ProductRating::USER_ID
        );
    }
}
