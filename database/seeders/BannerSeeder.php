<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Get list all files in banner folder
        $images = Storage::disk('public')->allFiles('banners');

        foreach ($images as $image) {

            // Get file name (without path)
            $fileName = basename($image);

            // Create a new banner instance
            $banner = new Banner();
            $banner->title = ucfirst(pathinfo($fileName, PATHINFO_FILENAME));
            $banner->image_url = Storage::url($image);

            $validator = Validator::make($banner->toArray(), [
                Banner::TITLE => 'required|string|max:255',
                Banner::IMAGE_URL => 'required',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $banner->save();
        }
    }
}
