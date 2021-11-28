<?php

namespace App\Util;

class Html
{
    public static function status($value)
    {
        if($value == "INATIVO"){
            return "<span class='badge badge-pill badge-danger'>${value}</span>";
        }
        return "<span class='badge badge-pill badge-success'>${value}</span>";
    }
}
