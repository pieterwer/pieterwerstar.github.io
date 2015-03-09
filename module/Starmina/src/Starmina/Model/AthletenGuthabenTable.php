<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class AthletenGuthabenTable
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
	 
	 public function getAthletenGuthaben($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('Athletid' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
		 }
         return $row;
     }
	 
	 public function saveAthletenGuthaben(AthletenGuthaben $gu)
     {
	
		 $data = array(
		 'Athletid' => $gu->Athletid, 
		 'Kontostand' => $gu->Kontostand, 
		 'id' => $gu->id, 
		 );
		 
		  $this->tableGateway->insert($data);
	 }
	 
     public function deleteAthletenGuthaben($id)
     {
		 
         $this->tableGateway->delete(array('Athletid' => (int) $id));
     }
 }