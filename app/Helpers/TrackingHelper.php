<?php

namespace App\Helpers;

class TrackingHelper
{
    public static function generate(): string
    {
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        return "DGEX{$year}{$random}";
    }
}
