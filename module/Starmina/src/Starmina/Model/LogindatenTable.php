<?php

namespace Starmina\Model;

use Zend\Db\TableGateway\TableGateway;

class LogindatenTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function saveLogindaten(Logindaten $ld) {
		$data = array (
				'Email' => $ld->Email,
				'Passwort' => md5($ld->Passwort),
				'Rolle' => $ld->Rolle
		);
		$this->tableGateway->insert ( $data );
	}
	public function saveLogindaten_verein(Logindaten $ld) {
		$data = array (
				'Email' => $ld->loginemail_verein, 
				'Rolle' => 'vr'
		)
		// 'Passwort' => $ld->pw1_verein, Vereins-Passwort wird vom Betreiber gesetzt (PR, 12.12.14)
		;
		
		$this->tableGateway->insert ( $data );
	}
	public function deleteLogindaten($alteEmail) {
		$this->tableGateway->delete ( array (
				'Email' => $alteEmail 
		) );
		// $this->saveLogindaten_verein($logindaten);
	}
	
	public function updateRolle($Email)
     {
		 $data = array(
		 'Rolle' => 'dl'
		 );		 
		
 		$this->tableGateway->update($data, array (
				'Email' =>$Email) );
	 }
}