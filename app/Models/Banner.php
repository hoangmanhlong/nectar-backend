<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Banner extends Model
{

    const DISPLAY_PRIORITIES = [
        'low' => 0,
        'medium' => 1,
        'high' => 2,
    ];

    const TABLE_NAME = 'banners';

    const ID = 'id';
    const TITLE = 'title';
    const IMAGE_URL = 'image_url';
    const DISPLAY_PRIORITY = 'display_priority';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::ID,
        self::TITLE,
        self::IMAGE_URL,
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        self::DISPLAY_PRIORITY
    ];

    public static function getBanners(): Collection|array
    {
        try {
            return self::all()->map(function ($banner) {
                $banner->image_url = AppUtils::getImageUrlAttribute(value: $banner->image_url);
                return $banner;
            });
        } catch (Exception) {
            return [];
        }
    }
}
