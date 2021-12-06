<?php

namespace App\Models;

abstract class Status {
    const ATIVO = "ATIVO";
    const INATIVO = "INATIVO";
    const EM_PROCESSO = "EM_PROCESSO";
    const AGUARDANDO_LIBERACAO = "AGUARDANDO_LIBERACAO";
}
