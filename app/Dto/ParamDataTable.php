<?php

namespace App\Dto;

class ParamDataTable
{

    private $draw;
    private $begin;
    private $end;
    private $search;
    private $orderField;
    private $orderDirection;

    public function __construct(){
        $this->draw = 1;
        $this->begin = 0;
        $this->end = 10;
    }

    public static function init($draw = 1, $begin = 0, $end = 10, $orderField = "", $orderDirection = "ASC"){
        $paramDT = new ParamDataTable();
        $paramDT->setDraw($draw);
        $paramDT->setBegin($begin);
        $paramDT->setEnd($end);
        $paramDT->setOrderField($orderField);
        $paramDT->setOrderDirection($orderDirection);
        return $paramDT;
    }


    /**
     * Get the value of draw
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * Set the value of draw
     *
     * @return  self
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;

        return $this;
    }

    /**
     * Get the value of begin
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set the value of begin
     *
     * @return  self
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get the value of end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set the value of end
     *
     * @return  self
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get the value of search
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set the value of search
     *
     * @return  self
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get the value of orderField
     */
    public function getOrderField()
    {
        return $this->orderField;
    }

    /**
     * Set the value of orderField
     *
     * @return  self
     */
    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;

        return $this;
    }

    /**
     * Get the value of orderDirection
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * Set the value of orderDirection
     *
     * @return  self
     */
    public function setOrderDirection($orderDirection)
    {
        $this->orderDirection = $orderDirection;

        return $this;
    }
}
