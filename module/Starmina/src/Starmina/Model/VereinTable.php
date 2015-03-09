<?php

// Table.phps auf hydrator Verfahren ändern ??? (12.12.14)
namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class VereinTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getVerein($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id' => $id 
		) );
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	 public function getVereinEmail($email)
     {
         //echo "Vereinmail";
         $rowset = $this->tableGateway->select(array('Adminemail' => $email));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $email");
         }
         return $row;
     } 
	 public function saveVerein(Verein $verein) {
		$data = array (
				'id' => $verein->id,
				'Name' => $verein->Name,
				// Name des Vereinsvertreters fehlte in Datenbank-Tabelle "Verein" (PR 07.12.14)
				'Vereinsvertreter' => $verein->Vereinsvertreter,
				// Name des Bankkontoinhabers fehlte in Datenbank-Tabelle "Verein" (PR 07.12.14)
				'Bankkontoinhaber' => $verein->Bankkontoinhaber,
				'IBAN' => $verein->IBAN,
				'BIC' => $verein->BIC,
				'Email' => $verein->Email,
				'Strasse' => $verein->Strasse,
				'Hausnummer' => $verein->Hausnummer,
				'Postleitzahl' => $verein->Postleitzahl,
				'Ort' => $verein->Ort,
				'Adminemail' => $verein->Adminemail, 
		 /*Passwort kommt vom Betreiber*/
		 // status des Vereins fehlt in Datenbank-Tabelle "Verein" (PR 07.12.14)
		 		'Status' => $verein->Status,
		 );
		
		$this->tableGateway->insert ( $data );
	}
	public function deleteVerein($id) {
		$this->tableGateway->delete ( array (
				'id' => ( int ) $id 
		) );
	}
	public function confirmVerein($id) {
		$verein = $this->getVerein ( $id );
		$verein->Status = true;
		$this->updateVerein ( $verein );
	}
	public function getAllUnconfirmedVerein() {
		return $this->tableGateway->select ( array (
				'Status' => '0' 
		) ); // "status" Spalte existiert in Vereinstabelle nicht
			     // status: pending oder status: 0 ??? (12.12.14)
	}
	
	/**
	 * gibt alle Athleten eines Vereins der gegebenen vereinID aus.
	 *
	 * @param unknown $vereinId        	
	 */
	public function getAllAthleten($vereinId) {
		$dbAdapterConfig = array (
				'driver' => 'Mysqli',
				'database' => 'testdata',
				'username' => 'root',
				'password' => '',
				'options' => array (
						'buffer_results' => true 
				) 
		);
		
		$dbAdapter = new Adapter ( $dbAdapterConfig );
		
		$sql = " SELECT athlet.* FROM athlet_verein_zuordnung, athlet WHERE athlet_verein_zuordnung.athletid = athlet.id AND athlet_verein_zuordnung.vereinid = ?";
		$resultSet = $dbAdapter->query ( $sql, array (
				$vereinId 
		) );
		return $resultSet->current ();
		
		// $statement = $sql->prepareStatementForSqlObject ( $select );
		// $result = $statement->execute ();
	}
	public function updateVerein($verein) {
		$data = array (
				'id' => $verein->id,
				'Name' => $verein->Name,
				
				// Name des Vereinsvertreters fehlt in Datenbank-Tabelle "Verein" (PR 07.12.14)
				'Vereinsvertreter' => $verein->Vereinsvertreter,
				// Name des Bankkontoinhabers fehlt in Datenbank-Tabelle "Verein" (PR 07.12.14)
				'Bankkontoinhaber' => $verein->Bankkontoinhaber,
				'IBAN' => $verein->IBAN,
				'BIC' => $verein->BIC,
				'Email' => $verein->Email,
				'Strasse' => $verein->Strasse,
				'Hausnummer' => $verein->Hausnummer,
				'Postleitzahl' => $verein->Postleitzahl,
				'Ort' => $verein->Ort,
				'Adminemail' => $verein->Adminemail,
				'Status' => $verein->Status,
				// sinnlos (siehe oben ---> Vereinsvertreter) 'Vereinsvertretername' => $verein->Vereinsvertretername
				/*Passwort kommt vom Betreiber*/
				// status des Vereins fehlt in Datenbank-Tabelle "Verein" (PR 07.12.14)
		);
		echo $verein->Adminemail;
		echo $data['Adminemail'];
		echo $data['id'];
		echo $data['Vereinsvertreter']; // editiert auf von Vereinsvertretername
		$this->tableGateway->update ( $data, array (
				'id' => $data['id']
		) );
	}
	public function wechselVorsitzenden($verein) {
		$verein->Status = 0;
		$this->updateVerein ( $verein );
	}
}