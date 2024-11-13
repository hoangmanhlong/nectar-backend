<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppResponse;
use App\Models\AppUtils;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductRating;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $ratingProductRequestDataRule = [
        Product::RATING => ['required', 'in:1,2,3,4,5']
    ];

    function __invoke()
    {
        $products = Product::getProducts();

        if ($products === null || empty($products)) {
            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: []
            );
        }

        // Group 1: Recommend for you (10 random products)
        $productsArray = $products->toArray();
        $recommendedProductKeys = array_rand($productsArray, 10);
        $recommendedProducts = array_map(fn($key) => $productsArray[$key], $recommendedProductKeys);
        $group1 = new ProductGroup(1, 'Recommend for you', $recommendedProducts);

        // Group 3: Các sản phẩm thuộc category = 6
        $productsArray = $products->toArray();
        $productsOfCategory6 = array_filter($productsArray, function ($product) {
            return $product['category_id'] == 6;
        });

        $group3 = new ProductGroup(3, 'Discovery', array_values($productsOfCategory6));

        $productgroups = [
            [
                'id' => $group1->id,
                'name' => $group1->name,
                'products' => $group1->products
            ],
            [
                'id' => $group3->id,
                'name' => $group3->name,
                'products' => $group3->products
            ],

        ];

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: $productgroups
        );
    }

    public function getProductById(int $productId)
    {
        try {
            $user = auth()->user();

            $isAuth  = $user !== null;

            $product = Product::getProductById(id: $productId);

            if (!$product) {
                return AppResponse::success(
                    status: AppResponse::ERROR_STATUS
                );
            }

            $review = $product->ratings()->avg(ProductRating::RATING) ?? 0;

            $isFavorite = null;

            $ratingOfMe = 0;

            if ($isAuth) {
                $userData = $user->userData;

                $isFavorite = $userData->favoriteProducts()
                    ->where(FavoriteProduct::PRODUCT_ID, $productId)
                    ->exists();

                $ratingOfMe = $userData->ratedProducts()
                    ->where(ProductRating::PRODUCT_ID, $productId)
                    ->value(ProductRating::RATING) ?? 0;
            }

            $product->review = round($review, 1);
            $product->is_favorite = $isFavorite;
            $product->rating = $ratingOfMe;

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: $product
            );
        } catch (Exception $e) {
            echo $e;
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function getFavoriteProducts()
    {
        try {
            $favoriteProducts = auth()->user()
                ->userData
                ->favoriteProducts
                ->map(function ($product) {
                    return Product::convertProductImage($product);
                });
            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: $favoriteProducts
            );
        } catch (Exception) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS,
                message: __('messages.get_favorite_products_error')
            );
        }
    }

    public function search(Request $request)
    {

        $keyword = $request->input(Product::KEYWORD);

        // Check if keyword exists
        if (!$keyword) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS,
                message: __('messages.search_product_error')
            );
        }

        $searchedProducts = Product::searchProduct(keyword: $keyword);

        return AppResponse::success(
            status: AppResponse::SUCCESS_STATUS,
            data: $searchedProducts
        );
    }

    public function favoriteProduct(int $productId)
    {
        try {
            $userData = auth()->user()->userData;

            // The toggle method of the belongsToMany relationship in Laravel.
            // This method will check if the product has been added to the user's wishlist.
            // If it has, it will remove the product from the list. Otherwise, if it has not, it will
            // add the product to the list.
            $userData->favoriteProducts()->toggle($productId);

            $isFavorite = $userData->favoriteProducts->contains($productId);

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: ['is_favorite' => $isFavorite]
            );
        } catch (Exception) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS
            );
        }
    }

    public function ratingProduct(Request $request)
    {
        try {
            // Validate request parameters
            $validationResponse = AppUtils::validateParamsWithRule($request->all(), $this->ratingProductRequestDataRule);
            if ($validationResponse) return $validationResponse;

            // Get authenticated user data
            $userData = auth()->user()->userData;
            $productId = $request->input(Product::ID);
            $rating = $request->input(Product::RATING);

            // Update or create rating for the product
            $userData->ratings()->updateOrCreate(
                [ProductRating::USER_ID => $userData->id, ProductRating::PRODUCT_ID => $productId],
                [ProductRating::RATING => $rating]
            );

            // Calculate the average rating of the product
            $product = Product::findOrFail($productId); // Throws 404 if product not found
            $averageRating = $product->ratings()->avg(ProductRating::RATING);

            return AppResponse::success(
                status: AppResponse::SUCCESS_STATUS,
                data: [
                    Product::REVIEW => round($averageRating, 1), // Round to one decimal for readability
                    ProductRating::RATING => $rating
                ]
            );
        } catch (\Exception $e) {
            return AppResponse::success(
                status: AppResponse::ERROR_STATUS,
                message: 'An error occurred while processing the rating.'
            );
        }
    }
}
