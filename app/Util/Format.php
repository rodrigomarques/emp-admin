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

    public static function fnDateView($date, $complete = false){
        try{
            if($complete){
                $carbonDate = \Carbon\Carbon::parse($date);
                return $carbonDate->format("d/m/Y H:i:s");
            }
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

    public static function getNumberOnly($value){
        $value = preg_replace('/[^0-9.]/', '', $value);
        return $value;
    }

    public static function getMonth($index){
        if($index <= 0) $index += 12;
        switch($index){
            case '1': return "JANEIRO";
            case '2': return "FEVEREIRO";
            case '3': return "MARÇO";
            case '4': return "ABRIL";
            case '5': return "MAIO";
            case '6': return "JUNHO";
            case '7': return "JULHO";
            case '8': return "AGOSTO";
            case '9': return "SETEMBRO";
            case '10': return "OUTUBRO";
            case '11': return "NOVEMBRO";
            case '12': return "DEZEMBRO";
            default : return "";
        }
    }
}
