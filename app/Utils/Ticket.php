<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class Ticket
{
    public static function generateTicket($data)
    {
        $image = ImageManager::gd()->read(Storage::get('template.png'));
        $image->text('The quick brown fox', 120, 100, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/comic-sans.ttf'));
            $font->size(32);
            $font->color('fff');
        });
        $image = $image->toPng()->toDataUri();
        return $image;
    }
}
