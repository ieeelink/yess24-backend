<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class Ticketing
{
    public static function generateCredentials($count): string
    {
        if ($count < 10) {
            return "YESS000".$count;
        }
        elseif ($count < 100) {
            return "YESS00".$count;
        }
        elseif ($count < 1000) {
            return "YESS0".$count;
        }
        return "YESS".$count;


    }
    public static function generateTicketNumber($ticket_type): string
    {
        $count = Storage::json('count.json');
        if ($ticket_type == "Early Bird")
        {
            return self::generateCredentials($count["Early Bird Count"]);
        }

        return self::generateCredentials($count["count"]);
    }

    public static function incrementCount($ticket_type): void
    {
        $count = Storage::json('count.json');
        if ($ticket_type == "Early Bird"){
            $count['Early Bird Count'] = $count['Early Bird Count'] + 1;
        }
        else
        {
            $count['count'] = $count["count"] + 1;
        }

        Storage::disk('local')->put('count.json', json_encode($count));
    }
}
