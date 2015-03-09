<?php

// InputFilter gehören laut Viktor nicht hier rein, sondern in die Datenbankmanagement-Klasse!
// Auslagern in Datenbankmanagement-Klasse (VereinTable.php) klappte bei mir (PR) am 12.12.14 nicht, da spinnt das zf rum!
namespace Starmina\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Verein {
	public $id;
	public $Name;
	public $Vereinsvertreter;
	public $Bankkontoinhaber;
	public $IBAN;
	public $BIC;
	public $Email;
	public $Strasse;
	public $Hausnummer;
	public $Postleitzahl;
	public $Ort;
	public $Adminemail;
	public $Passwort;
	public $pw2_verein;
	public $Status;
	// public $Vereinsvertretername; sinnlos, da oben $Vereinsvertreter für Vereinsvertreter
	
	// public $status; // ich (Philipp) weiß nicht, ob für $status private oder public sinnvoll ist (07.12.14)
	protected $inputFilter;
	protected $inputFilter2;
	
	public function exchangeArray($data) {
		$this->id = (! empty ( $data ['id'] )) ? $data ['id'] : null;
		$this->Name = (! empty ( $data ['Name'] )) ? $data ['Name'] : null;
		
		$this->Vereinsvertreter = (! empty($data['Vereinsvertreter'])) ? $data['Vereinsvertreter'] : null;
		// Spalte "Name des Bankkontoninhabers" für Verein war nicht in Datenbank Version 2.2 gelistet
		
		$this->Bankkontoinhaber = (! empty($data['Bankkontoinhaber'])) ? $data['Bankkontoinhaber'] : null;
		// Spalte "Name des Bankkontoninhabers" für Verein war nicht in Datenbank Version 2.2 gelistet
		
		$this->IBAN = (! empty ( $data ['IBAN'] )) ? $data ['IBAN'] : null;
		$this->BIC = (! empty ( $data ['BIC'] )) ? $data ['BIC'] : null;
		$this->Email = (! empty ( $data ['Email'] )) ? $data ['Email'] : null;
		$this->Strasse = (! empty ( $data ['Strasse'] )) ? $data ['Strasse'] : null;
		$this->Hausnummer = (! empty ( $data ['Hausnummer'] )) ? $data ['Hausnummer'] : null;
		$this->Postleitzahl = (! empty ( $data ['Postleitzahl'] )) ? $data ['Postleitzahl'] : null;
		$this->Ort = (! empty ( $data ['Ort'] )) ? $data ['Ort'] : null;
		$this->Adminemail = (! empty ( $data ['Adminemail'] )) ? $data ['Adminemail'] : null;
		$this->Passwort = (! empty ( $data ['Passwort'] )) ? $data ['Passwort'] : null;
		$this->pw2_verein = (! empty ( $data ['pw2_verein'] )) ? $data ['pw2_verein'] : null;
		$this->Status = (! empty ( $data ['Status'] )) ? $data ['Status'] : 0;
		// sinnlos (siehe obem) $this->Vereinsvertretername = (! empty ( $data ['Vereinsvertretername'] )) ? $data ['Vereinsvertretername'] : null;
		// $this->status = (!empty($data['status'])) ? $data['status'] : null;
		// Spalte "status" für Verein nicht in Datenbank gelistet
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		$standardFilter = array (
				array (
						'name' => 'StripTags' 
				),
				array (
						'name' => 'StringTrim' 
				) 
		);
		
		$standardValidators = array (
				array (
						'name' => 'StringLength',
						'options' => array (
								'encoding' => 'UTF-8',
								'min' => 1,
								'max' => 25 
						) 
				) 
		);
		
		$phoneValidator = array (
				array (
						'name' => 'Regex',
						'options' => array (
								'pattern' => '/^\+\d{2}\d{4}\d{8}$/' 
						) 
				) 
		);
		
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$inputFilter->add ( array (
					'name' => 'id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Name',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add(array(
					'name' => 'Vereinsvertreter',
			 		'required' => true,
			 		'filters' => $standardFilter,
			 		'validators' => $standardValidators
			) );
			
			$inputFilter->add(array(
			 		'name' => 'Bankkontoinhaber',
			 		'required' => true,
			 		'filters' => $standardFilter,
			 		'validators' => $standardValidators
			) );
			
			$inputFilter->add ( array (
					'name' => 'IBAN',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'BIC',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Email',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Strasse',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Hausnummer',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Postleitzahl',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Ort',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			
			$inputFilter->add ( array (
					'name' => 'Adminemail',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );
			/*
			 * $inputFilter->add(array(
			 * 'name' => 'pw1_verein',
			 * 'required' => true,
			 * 'filters' => $standardFilter,
			 * 'validators' => $standardValidators
			 * ));
			 *
			 * $inputFilter->add(array(
			 * 'name' => 'pw2_verein',
			 * 'required' => true,
			 * 'filters' => $standardFilter,
			 * 'validators' => $standardValidators
			 * ));
			 */
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	public function getAdminWechselInputFilter() {
		$standardFilter = array (
				array (
						'name' => 'StripTags' 
				),
				array (
						'name' => 'StringTrim' 
				) 
		);
		
		$standardValidators = array (
				array (
						'name' => 'StringLength',
						'options' => array (
								'encoding' => 'UTF-8',
								'min' => 1,
								'max' => 25 
						) 
				) 
		);
		
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$inputFilter->add ( array (
					'name' => 'Adminemail',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
		) );
		}
		$inputFilter->add ( array (
				'name' => 'Vereinsvertreter',
				'required' => true,
				'filters' => $standardFilter,
				'validators' => $standardValidators 
		) );
		 
		$this->inputFilter = $inputFilter;
		return $this->inputFilter;
	}
}