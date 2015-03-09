<?php

// VereinRegistrierungsForm erstellt von Philipp am 05./06.12.14

namespace Starmina\Form;

 use Zend\Form\Form;

 class VereinRegistrierungForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
		 
         parent::__construct('verein');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
		 
         $this->add(array(
             'name' => 'Name',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
         $this->add(array(
             'name' => 'Vereinsvertreter',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'IBAN',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'BIC',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'Bankkontoinhaber',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'Email',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'Strasse',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Hausnummer',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
         		 ),
         ));
		 
		 $this->add(array(
             'name' => 'Postleitzahl',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Ort',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Adminemail',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
         ));
		 /*	Vereins-Passwort kommt vom Betreiber
		 $this->add(array(
	 		'name' => 'pw1_verein',
			'type' => 'password',
        	'options' => array(
        	'label' => 'Bitte geben sie ein Passwort ein: ',
			),
        ));
		
		$this->add(array(
	 		'name' => 'pw2_verein',
			'type' => 'password',
        	'options' => array(
        	'label' => 'Bitte wiederholen sie ihr Passwort: ',
			),
        ));
		*/
		$this->add(array(
             'name' => 'Status',
             'type' => 'Hidden',
         ));
		 
         $this->add(array(
             'name' => 'vreg',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Registrieren', // warum war value "Go" voreingestellt ???
                 'id' => '', // für was ist die id "submitbutton" gut ???
				 // id Submitbutton entfernt am 13.12.14 ---> keine Auswirkung
				 'class' => 'button',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'vregreset',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Zurücksetzen', // VRF -> vregrest = von VereinsRegistrierungsForm in VereinsController public function vregresetAction() 
                 'id' => '',
				 'class' => 'button',
             ),
         ));
     }
 }
?>