<?php

namespace App\Utils;

class PhoneNumber
{
    public static function getNumber($phoneNumber)
    {
        $number = (int) preg_replace('/[^0-9]/', '', $phoneNumber);
        if($number > 10000000000){
            $number = $number % 10000000000;
        }
        return (string)$number;
    }
}
