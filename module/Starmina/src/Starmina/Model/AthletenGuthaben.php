<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class AthletenGuthaben
 {
	 public $id;
     public $Kontostand;
	 public $Athletid;
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->Athletid  			= (!empty($data['Athletid'])) ? $data['Athletid'] : null;
		 $this->Kontostand  		= (!empty($data['Kontostand'])) ? $data['Kontostand'] : null;
		 $this->id  				= (!empty($data['id'])) ? $data['id'] : null;
     
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