<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class MotivationZuordnungTable
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
	 
	 public function saveMotivationZuordnung(MotivationZuordnung $mo)
     {
	
		 $data = array( 
		 'Athletid' => $mo->Athletid, 
		 'Motivationid' => $mo->Motivationid,
		  
		 );
		 
		  $this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue; 

	 }
     
 }