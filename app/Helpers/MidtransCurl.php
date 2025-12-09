<?php

namespace App\Helpers;

class MidtransCurl
{
    public static function disableSSL()
    {
        \Midtrans\Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
    }
}
