<?php

namespace App\Repositories;

use App\Models\Planos;
use App\Models\Status;

use App\Dto\ParamDataTable;

class CadastroRepository
{
    public function search(ParamDataTable $param) {
        $query = new Planos();

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("plano", "like", "%" . $search . "%");
            });
        }

        $query = $query->where("status", Status::ATIVO);
        $query = $query->offset($param->getBegin())
                        ->limit($param->getEnd());
        if(isset(Planos::$dataTableViewColumns[$param->getOrderField()])){
            $query = $query->orderBy(Planos::$dataTableViewColumns[$param->getOrderField()], $param->getOrderDirection());
        }

        return $query;
    }

    public function searchCount(ParamDataTable $param) {
        $query = new Planos();

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("plano", "like", "%" . $search . "%");
            });
        }
        $query = $query->where("status", Status::ATIVO);

       return $query->count();
    }
}
