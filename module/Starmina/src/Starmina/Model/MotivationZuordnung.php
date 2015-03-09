<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class MotivationZuordnung
 {
	 public $Motivationid;
	 public $Athletid;
    
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->Athletid  			= (!empty($data['Athletid'])) ? $data['Athletid'] : null;
		 $this->Motivationid  		= (!empty($data['Motivationid'])) ? $data['Motivationid'] : null;
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