<?php

namespace App\Repositories;

use App\Models\Associado;
use App\Models\Status;

use App\Dto\ParamDataTable;

class AssociadoRepository
{
    public function search(ParamDataTable $param) {
        $query = new Associado();
        $query = $query->join("subcategorias", "subcategorias.id", "=", "associados.subcategoria_id");
        $query = $query->join("categorias", "subcategorias.categoria_id", "=", "categorias.id");
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
        if(isset(Associado::$dataTableViewColumns[$param->getOrderField()])){
            $query = $query->orderBy(Associado::$dataTableViewColumns[$param->getOrderField()], $param->getOrderDirection());
        }

        return $query;
    }

    public function searchCount(ParamDataTable $param) {
        $query = new Associado();

        $query = $query->join("subcategorias", "subcategorias.id", "=", "associados.subcategoria_id");
        $query = $query->join("categorias", "subcategorias.categoria_id", "=", "categorias.id");
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
