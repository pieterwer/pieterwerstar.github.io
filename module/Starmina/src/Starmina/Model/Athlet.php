<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class Athlet
 {
     public $id; // müssen alle 'public' sein, mit 'private' haut in Datenbank schreiben nicht mehr hin ---> ausprobiert von Phil am 07.12.14
     public $Vorname;
     public $Name;
	 public $Titel;
	 public $Zusatz;
//	 public $Strasse;
//	 public $Hausnummer;
//	 public $Postleitzahl;
//	 public $Ort;
//	 public $Land;
	 public $Telefonnummer1;
	 public $Telefonnummer2;
	 public $Telefonnummer3;
	 public $tel1landauswahl_athlet;
	 public $tel2landauswahl_athlet;
	 public $tel3landauswahl_athlet;
	 public $faxlandauswahl_athlet;
	 public $Fax;
	 public $Firma;
	 public $Geburtstag;
	 //public $bild_athlet;
	 //public $bildid;
	 public $Geschlecht;
	 public $Werbung;
	 public $Historie;
	 public $Umkreis;
	 public $IBAN;
	 public $BIC;
	 public $name_athlet_bkih;
	 public $Email;
	 public $Passwort;
	 public $pw2_athlet;
	 public $email_logindaten;
	 
	 
	 public $status;
	 protected $inputFilter;

     public function exchangeArray($data)
     {	
         $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		 $this->Vorname  	= (!empty($data['Vorname'])) ? $data['Vorname'] : null;
         $this->Name 	= (!empty($data['Name'])) ? $data['Name'] : null;
		 $this->Titel  		= (!empty($data['Titel'])) ? $data['Titel'] : null;
		 $this->Zusatz  		= (!empty($data['Zusatz'])) ? $data['Zusatz'] : null;
		 error_reporting(0);
		 $this->Telefonnummer1  		= (!empty($data['Telefonnummer1'])) ? $data['tel1landauswahl_athlet']  . 	                                       $data['Telefonnummer1'] : null;
		 $this->Telefonnummer2  		= (!empty($data['Telefonnummer2'])) ? $data['tel2landauswahl_athlet'] .                                       $data['Telefonnummer2'] : null;
		 $this->Telefonnummer3 		= (!empty($data['Telefonnummer3'])) ? $data['tel3landauswahl_athlet'] .                                       $data['Telefonnummer3'] : null;
		 $this->Fax  		= (!empty($data['Fax'])) ? $data['faxlandauswahl_athlet'] . $data['Fax'] :                                        null;
		 error_reporting(E_ALL);
		 $this->Firma  		= (!empty($data['Firma'])) ? $data['Firma'] : null;
		 // Geburtstag
		 $this->Geburtstag 	= (!empty($data['Geburtstag'])) ? $data['Geburtstag'] : null;
		 //$this->bild_athlet  		= (!empty($data['image-file'])) ? $data['image-file'] : null;
		 $this->Geschlecht  	= (!empty($data['Geschlecht'])) ? $data['Geschlecht'] : null;
		 $this->Werbung  	= (!empty($data['Werbung'])) ? $data['Werbung'] : null;
		 $this->Historie  	= (!empty($data['Historie'])) ? $data['Historie'] : null;
		 $this->Umkreis  	= (!empty($data['Umkreis'])) ? $data['Umkreis'] : null;
		 $this->IBAN  		= (!empty($data['IBAN'])) ? $data['IBAN'] : null;
		 $this->BIC  		= (!empty($data['BIC'])) ? $data['BIC'] : null;
		 //$this->name_athlet_bkih  = (!empty($data[''])) ? $data[''] : null;
		 $this->Email  	= (!empty($data['Email'])) ? $data['Email'] : null;
		 //$this->pw1_athlet  		= (!empty($data['Passwort'])) ? $data['Passwort'] : null;
		 //$this->pw2_athlet  		= (!empty($data['werbung'])) ? $data['werbung'] : null;
		 $this->email_logindaten  	= (!empty($data['email_logindaten'])) ? $data['email_logindaten'] : null;
		 
		 $this->status  			= (!empty($data['status'])) ? $data['status'] : null;
	
     }
	 
	 //Funktion um ID für Bild zu setzen Alex Giedt 21.12.2014
	 
	  public function setbildid($id)
	 {
		 $this->bildid = $id;
	 }
	 
	 
	 public function getArrayCopy()
     {
         return get_object_vars($this);
     }
	 
	 
	 public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
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
		
		$emailValidator = array (
				array (
						'name' => 'Regex',
						'options' => array (
								'pattern' => '/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6}$/' 
						) 
				) 
		);
			 
       if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

             $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                 'filters'  => array(
                    array('name' => 'Int'),
                ),
             ));

		$inputFilter->add(array(
                'name'     => 'Kontostand',
                'required' => true,
                 'filters'  => array(
                    array('name' => 'Int'),
                ),
             ));
			 
             $inputFilter->add(array(
                 'name'     => 'Vorname',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 
             $inputFilter->add(array(
                 'name'     => 'Name',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 
			 $inputFilter->add(array(
                 'name'     => 'Titel',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			  $inputFilter->add ( array (
					'name' => 'Strasse',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );	
			 
			 $inputFilter->add(array(
                 'name'     => 'Hausnummer',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'Land',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'Ort',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));				
			
			
			 /*$inputFilter->add(array(
                 'name'     => 'Zusatz',
				  'required' => false,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));*/
			 
			$inputFilter->add(array(
                 'name'     => 'Postleitzahl',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => array(
				 	array(
				 		'name' => 'Digits',
						'options' => array(
							'min' => 4,
							'max' => 10,
							))
						)));
			
			 $inputFilter->add(array(
                 'name'     => 'Telefonnummer1',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => array(
				 	array(
				 		'name' => 'Digits',
						'options' => array(
							'min' => 4,
							'max' => 10,
							))
						)));
						
						
			/* 			
			 $inputFilter->add(array(
                 'name'     => 'tel2_athlet',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $numberValidator,
             ));								
			 
			 
			 $inputFilter->add(array(
                 'name'     => 'tel3_athlet',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $numberValidator,
             ));
			 
			 
			 $inputFilter->add(array(
                 'name'     => 'fax_athlet',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $numberValidator,
             )); */
			 	
				
			 /*$inputFilter->add(array(
                 'name'     => 'Firma',
				 'required' => false,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));*/
			 
			 // Geburtstagseingabe wird auf php Ebene gefiltert...wir haben aber gar keinen inputFilter definiert...strange!!! (14.12.14)
			 
			 /*$inputFilter->add(array(
			 	'name' => 'geburtstag_athlet',
				'required' => true,
				'filters' => array(
				'validators' => array(
					'format' => 'Y-m-d',
				))));*/
				
			 //Bild
			 //Geschlecht
			 //Werbung
			 //Historie
			 //Umkreis
			 
			 
			 $inputFilter->add(array(
                 'name'     => 'IBAN',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 
			 $inputFilter->add(array(
                 'name'     => 'BIC',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));		
			 
			  
			 $inputFilter->add(array(
                 'name'     => 'Email',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $emailValidator
             ));		
			 // name_athlet_bkih
			 
			 // email_athlet
			 
			 // pw_athlet
			 
			 	 $inputFilter->add(array(
                 'name'     => 'Passwort',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => array(
				 	array(
						'name' => 'StringLength',
						'options' => array(
							'min' => '8',
							'max' => '16'
							)
						 )
				  )));
			 
			 
			 //// pw_athlet
			 
				$inputFilter->add(array(
                 'name'     => 'pw2_athlet',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => array(
				 	array(
						'name' => 'StringLength',
						'options' => array(
							'min' => '8',
							'max' => '16'
							)),
					array(
						'name' => 'Identical',
						'options' => array(
						'token' => 'Passwort'
							))
				)					
            )
		); 



             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 
 }