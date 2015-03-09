<?php


namespace Starmina\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class VereinBuchung {
	public $id;
	public $Vereinid;
	public $IBAN;
	public $BIC;
	public $Wert;
	public $Datum;
	public $Verwendungszweck;
	public $Verwendungsart;

	

	public function exchangeArray($data) {
		
		$this->id = (! empty ( $data ['id'] )) ? $data ['id'] : null;
		$this->Vereinid = (! empty ( $data ['Vereinid'] )) ? $data ['Vereinid'] : null;
		$this->IBAN = (! empty ( $data ['IBAN'] )) ? $data ['IBAN'] : null;
		$this->BIC = (! empty ( $data ['BIC'] )) ? $data ['BIC'] : null;
		$this->Wert = (!empty ($data['Wert'])) ? $data['Wert'] : null;
		$this->Verwendungszweck = (!empty ($data['Verwendungszweck'])) ? $data['Verwendungszweck'] : null;
		$this->Verwendungsart = (!empty ($data['Verwendungsart'])) ? $data['Verwendungsart'] : null;

	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	
	
}