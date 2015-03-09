<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class BildTable
 {
     protected $tableGateway;
	
     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
	
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }
	 
	  public function getBild($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('Athletid' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
		 }
         return $row;
     }
	 
	 public function saveBild(Bild $bi)
     {
	
		 $data = array(
		 //'id' => $bi->, 
		 'Bildname' => $bi->bild_athlet['name'],
		 'Link' => $bi->link_athlet 
		  
		 );
		 
		  $this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue; 

	 }
     
 }