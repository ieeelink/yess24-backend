<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class Ticket
{
    public static function generateTicket($data, $user_image)
    {
        $user_image = ImageManager::gd()->read($user_image)->cover(300, 300);
        $canvas = ImageManager::gd()->create(1000, 1000);
//        $image = ImageManager::gd()->read(Storage::get('template.png'));
//        $image->text('The quick brown fox', 120, 100, function (FontFactory $font) {
//            $font->filename(base_path('storage/app/fonts/comic-sans.ttf'));
//            $font->size(32);
//            $font->color('fff');
//        });
//        $image = $image->toPng()->toDataUri();
        $canvas->place($user_image);

        return $canvas->toPng()->toDataUri();
    }
}
