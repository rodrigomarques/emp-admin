<?php

namespace App\Repositories;

use App\Models\Dependente;
use App\Models\Status;

use App\Dto\ParamDataTable;

class DependenteRepository
{
    public function search(ParamDataTable $param) {
        $query = new Dependente();
        $query = $query->join("associados", "dependentes.associado_id", "=", "associados.id");
        $query = $query->join("usuarios", "usuarios.id", "=", "associados.usuario_id");

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("usuarios.nome", "like", "%" . $search . "%");
                $q = $q->orWhere("usuarios.email", "like", "%" . $search . "%");
            });
        }

        $query = $query->offset($param->getBegin())
                        ->limit($param->getEnd());
        if(isset(Dependente::$dataTableViewColumns[$param->getOrderField()])){
            $query = $query->orderBy(Dependente::$dataTableViewColumns[$param->getOrderField()], $param->getOrderDirection());
        }

        return $query;
    }

    public function searchCount(ParamDataTable $param) {
        $query = new Dependente();
        $query = $query->join("associados", "dependentes.associado_id", "=", "associados.id");
        $query = $query->join("usuarios", "usuarios.id", "=", "associados.usuario_id");

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("usuarios.nome", "like", "%" . $search . "%");
                $q = $q->orWhere("usuarios.email", "like", "%" . $search . "%");
            });
        }

       return $query->count();
    }
}
