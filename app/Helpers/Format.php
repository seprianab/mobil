<?php

use Carbon\Carbon;
if (!function_exists('toDate')) {
    function toDate($datetime, $format = 'date')
    {
        if($datetime == null) return null;
        
        if($format == 'datetime'){
            $format = 'd M Y H:m';
        } else if($format == 'date'){
            $format = 'd M Y';
        }
        return Carbon::parse($datetime)->format($format);
    }
}
if (!function_exists('toSystemDate')) {
    function toSystemDate($datetime)
    {
        $datetime = str_replace("/", "-", $datetime);
        return Carbon::parse($datetime);
    }
}

if (!function_exists('toNumber')) {
    function toNumber($double, $decimal = 0, $dec_point = ",")
    {
        if($double == '' || $double == null) return 0;

        $thousand_sep = $dec_point == "," ? "." : ",";
        return number_format($double, $decimal, $dec_point, $thousand_sep);
    }
}

if (!function_exists('toSystemNumber')) {
    function toSystemNumber($string)
    {
        if($string == '' || $string == null) return 0;

        return str_replace('.', '', str_replace(',', '.', $string));
    }
}