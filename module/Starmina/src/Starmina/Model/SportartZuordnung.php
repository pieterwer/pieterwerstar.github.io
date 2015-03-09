<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class SportartZuordnung
 {
	 public $sportart_athlet;
	 public $Athletid;
    
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->Athletid  			= (!empty($data['Athletid'])) ? $data['Athletid'] : null;
		 $this->sportart_athlet  	= (!empty($data['Sportartid'])) ? $data['Sportartid'] : null;
	 }
	 
	  public function getArrayCopy()
     {
         return get_object_vars($this);
     }
	 
	 public function setId($id)
	 {
		 $this->Athletid = $id;
	 }
	 
	 

 }