<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function removeProtocol($url)
    {
        return trim(preg_replace('#^[^:/.]*[:/]+#i', '', $url), '/');
    }
}
