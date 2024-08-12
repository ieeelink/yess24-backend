<?php

namespace App\Utils;

use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Decoders\DataUriImageDecoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class Ticket
{
    public static function generateTicket($data, $ticket_type)
    {
        $ticket_file_array = ["Normal 1.jpg", "Normal 2.jpg"];
        $ticket_file = $ticket_file_array[array_rand($ticket_file_array)];
        if($ticket_type == "Contributor Ticket")
        {
            $ticket_file = "contributor.jpg";
        }
        $image = ImageManager::gd()->read(Storage::get($ticket_file));

        $image->text($data['name'], 1717, 671, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/Montserrat.ttf'));
            $font->size(58.85);
            $font->color('fff');
            $font->align('right');
            $font->stroke('fff', 1);
        });

        $image->text('Ticket No.  ' . $data['ticket_id'], 1717, 908, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/Montserrat.ttf'));
            $font->size(65);
            $font->color('FF6829');
            $font->align('right');
            $font->stroke('FF6829', 1);
        });

        $image->text('Ticket No.  ' . $data['ticket_id'], 2152, 908, function (FontFactory $font) {
            $font->filename(base_path('storage/app/fonts/Montserrat.ttf'));
            $font->size(65);
            $font->color('FFF');
            $font->align('center');
            $font->stroke('FFF', 1);
        });

        $options = new QROptions;
        $options->imageTransparent = true;
        $options->returnResource = true;
        $options->outputType = QROutputInterface::GDIMAGE_JPG;

        $qrcode = ImageManager::gd()->read((new QRCode($options))->render($data['ticket_id']));
        $qrcode->resize(450, 450);

        $image->place($qrcode, 'right', 115, -109);
        return $image->toPng()->toDataUri();
    }
}
