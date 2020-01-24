<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monthExpense extends Model
{
    protected $monthAndYear;
    protected $expense;
    public function getMonthAndYear(){
        return $this->monthAndYear;
    }
    public function setExpense($expense){
        $this->expense =  $expense;
    }
    public function getExpense(){
        return $this->expense;
    }
    public function __construct ($monthAndYear,$expense)
	{   
        $this->monthAndYear= $monthAndYear;
        $this->expense = $expense;
    }

}
