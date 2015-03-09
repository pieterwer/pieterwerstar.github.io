<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class AnschriftTable
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
	 
	 public function getAnschrift($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('Athletid' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
		 }
         return $row;
     }
	 
	 public function saveAnschrift(Anschrift $an)
     {
	
		 $data = array(
		 'Athletid' => $an->id, 
		 'Strasse' => $an->Strasse, 
		 'Hausnummer' => $an->Hausnummer, 
		 'Postleitzahl' => $an->Postleitzahl, 
		 'Ort' => $an->Ort,
		 'Land' => $an->Land, 
		 );
		 
		  $this->tableGateway->insert($data);
		  	 }
	 
	 
	   public function updateAnschrift($anschrift)
     {
		 $data = array(
		 'Athletid' => $anschrift->id, 
		 'Strasse' => $anschrift->Strasse, 
		 'Hausnummer' => $anschrift->Hausnummer, 
		 'Postleitzahl' => $anschrift->Postleitzahl, 
		 'Ort' => $anschrift->Ort,
		 'Land' => $anschrift->Land, 
		 );		 
		
 		$this->tableGateway->update($data, array (
				'Athletid' =>$anschrift->id) );
	 }
	 
	 
     public function deleteAnschrift($id)
     {
		 
         $this->tableGateway->delete(array('Athletid' => (int) $id));
     }
 }