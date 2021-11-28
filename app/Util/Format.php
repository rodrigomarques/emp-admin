<?php

namespace App\Util;

class Format
{
    public static function fn($number, $decimal = 2, $separatorDec = "," , $separatorTho = ""){
        if(is_numeric($number)){
            return "R$ " . number_format($number, $decimal, $separatorDec, $separatorTho);
        }

        return "R$ 0,00";
    }

    public static function fnDateView($date){
        try{
            $carbonDate = \Carbon\Carbon::createFromFormat("Y-m-d", $date);
            return $carbonDate->format("d/m/Y");
        }catch(\Exception $e){
            \Log::error("Erro format date", [$date]);
            return $date;
        }
    }
}
