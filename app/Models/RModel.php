<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class RModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = [];
    protected $rules = [];
    protected $errors;
    protected $messages = [];

    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules, $this->messages);
        if ($v->fails())
        {
            $this->errors = $v->errors();
            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function beforeSave() {

        return true;
    }

    public function save(array $options = []) {
        try {
            if (!$this->beforeSave()) {
                return false;
            }

            return parent::save($options);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function __destruct(){
        \DB::disconnect();
    }

    public function formatDate($date){

    }
}
