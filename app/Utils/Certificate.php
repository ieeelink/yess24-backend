<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class Certificate
{
    public static function generateCertificate($name, $college)
    {
        $image = ImageManager::gd()->read(Storage::get("certificate_template.jpg"));
        $image->text($name, 840, 550.53, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/Raleway.ttf'));
            $font->size(80);
            $font->color('2B2849');
            $font->align('center');
            $font->stroke('2B2849', 3);
        });
        $image->text($college, 840, 628, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/Raleway.ttf'));
            $font->size(44.16);
            $font->color('404040');
            $font->align('center');
            $font->stroke('404040');
        });
        return $image->toPng()->toDataUri();
    }
}
