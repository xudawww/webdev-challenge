<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    protected $date;
    protected $category;
    protected $lotTitle;
    protected $lotLocation;
    protected $lotCondition;
    protected $preTaxAmount;
    protected $taxName;
    protected $taxAmount;
    
    
    public function __construct ($date, $category,$lotTitle,$lotLocation,$lotCondition,$preTaxAmount,$taxName,$taxAmount)
	{   
        $this->date = $date;
        $this->category = $category;
        $this->lotTitle = $lotTitle;
        $this->lotLocation = $lotLocation;
        $this->lotCondition = $lotCondition;
        $this->preTaxAmount= $preTaxAmount;
        $this->taxName = $taxName;
        $this->taxAmount = $taxAmount;
    }

    public function getDate(){
        return $this->date;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getLotTitle(){
        return $this->lotTitle;
    }
    public function getlotLocation(){
        return $this->lotLocation; 
    }

    public function getCondition(){
        return $this->lotCondition;
    }

    public function getPre_taxAmount(){
        return $this->preTaxAmount;
        
    }
    public function getTax_Name(){
        return $this->taxName;

    }
    public function getTaxAmount(){
        return $this->taxAmount;

    }




}
