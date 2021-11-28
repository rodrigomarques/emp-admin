<?php

namespace App\Repositories;

use App\Models\Cupom;
use App\Models\Status;

use App\Dto\ParamDataTable;

class CupomRepository
{
    public function search(ParamDataTable $param) {
        $query = new Cupom();

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("titulo", "like", "%" . $search . "%");
                $q = $q->orWhere("codigo", "like", "%" . $search . "%");
            });
        }

        $query = $query->where("status", Status::ATIVO);
        $query = $query->offset($param->getBegin())
                        ->limit($param->getEnd());
        if(isset(Cupom::$dataTableViewColumns[$param->getOrderField()])){
            $query = $query->orderBy(Cupom::$dataTableViewColumns[$param->getOrderField()], $param->getOrderDirection());
        }

        return $query;
    }

    public function searchCount(ParamDataTable $param) {
        $query = new Cupom();

        if($param->getSearch() != null && $param->getSearch() != ""){
            $search = $param->getSearch();

            $query = $query->where(function($q) use($search){
                $q = $q->orWhere("titulo", "like", "%" . $search . "%");
                $q = $q->orWhere("codigo", "like", "%" . $search . "%");
            });
        }
        $query = $query->where("status", Status::ATIVO);

       return $query->count();
    }
}
