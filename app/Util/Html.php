<?php

namespace App\Util;

use App\Models\Status;

class Html
{
    public static function status($value)
    {
        if($value == Status::INATIVO){
            return "<span class='badge badge-pill badge-danger'>${value}</span>";
        }

        if(in_array($value, [Status::EM_PROCESSO, Status::AGUARDANDO_LIBERACAO])){
            return "<span class='badge badge-pill badge-warning'>Em análise</span>";
        }

        return "<span class='badge badge-pill badge-success'>${value}</span>";
    }

    public static function linkDataTable($id, $class = "", $classBtn = "", $textLink = "", $function = null)
    {
        if($textLink == "") $textLink = "<i class='${class}'></i>";
        if($function != null) $function = "onclick='${function}(this)'";
        return "<a href='#' data-id='${id}' class='${classBtn}' ${function}>${textLink}</a>";
    }
}
