<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoryExpense extends Model
{
    protected $cateogry;
    protected $expense;
    public function setExpense($expense){
        $this->expense = $expense;
    }
    public function getCateogry(){
        return $this->cateogry;
    }

    public function getExpense(){
        return $this->expense;
    }
    public function __construct ($cateogry,$expense)
	{   
        $this->cateogry= $cateogry;
        $this->expense = $expense;
    }
}
