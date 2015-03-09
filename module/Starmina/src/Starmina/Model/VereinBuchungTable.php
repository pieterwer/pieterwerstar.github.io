<?php


namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class VereinBuchungTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getVereinBuchung($id) {
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
	public function buchen(Vereinbuchung $buchung) {
		$data = array (
				'id' => $buchung->id,
				'Vereinid'=> $buchung->Vereinid,
				'IBAN' => $buchung->IBAN,
				'BIC' => $buchung->BIC,
				'Wert' => $buchung->Wert,
				'Datum' => $buchung->Datum,
				'Verwendungzweck' => $buchung ->Verwendungszweck,
				'Verwendungsart' => $buchung ->Verwendungsart,
				
		 );
		
		$this->tableGateway->insert ( $data );
	}
}