<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class Motivation
 {
	 public $id;
     public $bezeichnung;
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->id  		= (!empty($data['id '])) ? $data['id '] : null;
		 $this->bezeichnung = (!empty($data['bezeichnung'])) ? $data['bezeichnung'] : null;      
     }
	 
	  public function getArrayCopy()
     {
         return get_object_vars($this);
     }
	 
	 public function getBezeichnung()
	 {
		 return $this->bezeichnung;
	 }
	 
 }