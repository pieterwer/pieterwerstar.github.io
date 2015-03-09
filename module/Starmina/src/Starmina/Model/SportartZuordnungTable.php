<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class SportartZuordnungTable
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
	 
	 public function saveSportart(Sportart $sp)
     {
	
		 $data = array( 
		 'Athletid' => $sp->Athletid, 
		 'Sportartid' => $sp->sportart_athlet,
		  
		 );
		 
		  $this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue; 

	 }
     
 }