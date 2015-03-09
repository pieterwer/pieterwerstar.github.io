<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class MotivationTable
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
	 
	 public function getMotivation()
     {
	 
		 return $this->tableGateway->select();
		 
	 }
     
 }