<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class Bild
 {
	 public $bild_athlet;
	 public $link_athlet;
    
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->bild_athlet  		= (!empty($data['image-file'])) ? $data['image-file'] : null;
		 //Link muss immer wieder angepasst werden, da sich die Ordnerbezeichnung noch ständig ändert und auf dem Server wird es auch ein anderer Link werden
		 $this->link_athlet  		= "Macintosh HD/Programme/XAMPP/xamppfiles/htdocs/group7starmina91neu/module/Starmina/src/Starmina/assets/" . $this->bild_athlet['name'];
	 }
	 
	  public function getArrayCopy()
     {
         return get_object_vars($this);
     }
	 
	 

 }