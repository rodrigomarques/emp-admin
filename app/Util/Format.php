<?php

namespace App\Util;

class Format
{
    public static function fn($number, $decimal = 2, $prefix = true, $separatorDec = "," , $separatorTho = ""){
        $symbol = $prefix ? "R$ " : "";

        if(is_numeric($number)){
            return $symbol . number_format($number, $decimal, $separatorDec, $separatorTho);
        }

        return "${symbol}0,00";
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

    public static function hideEmail($email){
        try{
            $emailPartes = explode("@", $email);
            return substr($emailPartes[0],0,2). "****" . substr($emailPartes[0],-2) . "@" . substr($emailPartes[1], 0, 3);
        }catch(\Exception $e){
            \Log::error("Hide email", [$e->getMessage()]);
            return "";
        }
    }
}
