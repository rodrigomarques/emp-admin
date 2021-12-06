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

    public static function linkDataTable($id, $class = "", $classBtn = "")
    {
        return "<a href='#' data-id='${id}' class='${classBtn}'><i class='${class}'></i></a>";
    }
}
