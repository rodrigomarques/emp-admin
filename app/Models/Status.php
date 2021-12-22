<?php

namespace App\Models;

abstract class Status {
    const ATIVO = "ATIVO";
    const INATIVO = "INATIVO";
    const CANCELADO = "CANCELADO";
    const EM_PROCESSO = "EM_PROCESSO";
    const AGUARDANDO_LIBERACAO = "AGUARDANDO_LIBERACAO";
    const AGUARDANDO_PAGAMENTO = "AGUARDANDO_PAGAMENTO";
}
