<?php

// AthletRegistrierungForm ergänzt / angepasst von Philipp am 06.12.14

namespace Starmina\Form;
use Zend\InputFilter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Form\Element;

 use Zend\Form\Form;

 class AthletRegistrierungForm extends Form
 {
	protected $dbAdapter;
    protected $action;
     public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())	//$name = null)
     {
		 $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
         
		 
         parent::__construct('athlet');
		 
		 //$test = $motivation->current();
		 
		 //echo $test->bezeichnung;

         $this->add(array(
		 	'name' => 'id',
            'type' => 'Hidden',		 
         ));
		 
		  $this->add(array(
		 	'name' => 'Kontostand',
            'type' => 'Hidden',	
			'value' => '0,0'	 
         ));
		 
		  $this->add(array(
		 	'name' => 'Rolle',
            'type' => 'Hidden',
			'attributes' => array(
				'value' => 'at',
             	)
         ));
		 
		 $this->add(array(
             'name' => 'status',
             'type' => 'Hidden',
			 'attributes' => array(
				'value' => '1',
             	)
         ));
		 
         $this->add(array(
            'name' => 'Vorname',
            'type' => 'Text',
			'options' => array(
				'label' => '',
             	),
         ));
		 
         $this->add(array(
             'name' => 'Name',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
         		 ),
         ));
		 
		 $this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'Titel',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			 'Herr' => 'Herr',
            			 'Frau' => 'Frau',
        				 ),
    				 ),
		));
		
		$this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'verein_auswahl',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => $this->getOptionsForVerein(),
    				 ),
		));
		
		 
		 $this->add(array(
             'name' => 'Zusatz',
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
		 
		 /*$this->add(array(
             'name' => 'Land',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Land: ',
             	 ),
         ));*/
		 
		  $this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'Land',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			 'DE' => 'Deutschland ',
            			 'OE' => 'Österreich ',
						 'SW' => 'Schweiz ',
        				 ),
    				 ),
		));
		 
		 $this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'tel1landauswahl_athlet',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			 '+49' => 'Deutschland +49',
            			 '+43' => 'Österreich +43',
						 '+41' => 'Schweiz +41',
        				 ),
    				 ),
		));
		
		$this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'tel2landauswahl_athlet',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			'+49' => 'Deutschland +49',
            			 '+43' => 'Österreich +43',
						 '+41' => 'Schweiz +41',
        				 ),
    				 ),
		));
		
		$this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'tel3landauswahl_athlet',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			'+49' => 'Deutschland +49',
            			 '+43' => 'Österreich +43',
						 '+41' => 'Schweiz +41',
        				 ),
    				 ),
		));
		
		$this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'faxlandauswahl_athlet',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			 '+49' => 'Deutschland +49',
            			 '+43' => 'Österreich +43',
						 '+41' => 'Schweiz +41',
        				 ),
    				 ),
		));
		 
		//$this->add(array(
//             'name' => 'vorwahltel1_athlet',
//             'type' => 'Text',
//             'options' => array(
//                 'label' => 'Vorwahl: ',
//           		 ),
//         ));
//		 
//		 $this->add(array(
//             'name' => 'vorwahltel2_athlet',
//             'type' => 'Text',
//             'options' => array(
//                 'label' => 'Vorwahl: ',
//           		 ),
//         ));
//		 
//		 $this->add(array(
//             'name' => 'vorwahltel3_athlet',
//             'type' => 'Text',
//             'options' => array(
//                 'label' => 'Vorwahl: ',
//           		 ),
//         ));
//		 
//		 $this->add(array(
//             'name' => 'vorwahlfax_athlet',
//             'type' => 'Text',
//             'options' => array(
//                 'label' => 'Vorwahl: ',
//           		 ),
//         ));
		 
		 $this->add(array(
             'name' => 'Telefonnummer1',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
           		 ),
         ));
		 
		 $this->add(array(
             'name' => 'Telefonnummer2',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Telefonnummer3',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));    
		 
		 $this->add(array(
             'name' => 'Fax',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Firma',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
            	  ),
         ));

// Sportarten und Motivationsgründe auslesen und über view anzeigen lassen ---> AG
		 $this->add(array(
      	  	'type' => 'Zend\Form\Element\MultiCheckbox',
          	'name' => 'Bezeichnung',
	        'attributes' => array(
		      'multiple' => 'multiple'),
              'options' => array(
                   'label' => '',
                   'value_options' =>  $this->getOptionsForMotivation()
				   /*array(
						'0' => 'Spass ' ,
						'1' => 'Gesundheit ',
						'2' => 'Wettkampfvorbereitung ',
						'3' => 'Fitness ',
						'4' => 'Gewichtsabnahme ',
						'5' => 'Ausgleich zum Beruf ',
						'6' => 'Kontakt mit anderen ',
						'7' => 'Sonstiges '
				)*/
				)
    		));

		  $this->add(array(
   		   'type' => 'Zend\Form\Element\MultiCheckbox',
   		   'name' => 'SportBezeichnung',
	       'attributes' => array(
	   	      'multiple' => 'multiple'),
              'options' => array(
              'label' => '',
              'value_options' =>  $this->getOptionsForSportart()
		 			/*array(
					'0' => 'Schwimmen',
					'1' => 'Laufen',
					'2' => 'Radfahren',
		 			'3' => 'Triathlon/Duathlon',
		 			'4' => 'Inlineskating',
		 			'5' => 'Nordic Walking',
		 			'6' => 'Skinlanglauf',
			 ))*/
			 )
		));

		 
		 $this->add(array(
	 		'name' => 'Geburtstag', 
			'type' => 'text',
        	'options' => array(
        	'label' => '',
			),
			'attributes' => array(
                		'placeholder' => 'YYYY-MM-DD',
            )
			
        ));
		 
		 
		 // Form um Bild hochzuladen -> geändert Alex Giedt 16.12 
		 
		$file = new Element\File('image-file');
		$file->setLabel('Bild Upload:')
             ->setAttribute('id', 'image-file');
		$this->add($file);
		
		/*
		 $this->add(array(
             'name' => 'bild_athlet',
             'type' => 'File',
             'options' => array(
                 'label' => 'Bild: ',
             	 ),
         ));*/
		 
		 $this->add(array(
		 	 'type' => 'Zend\Form\Element\Select',
   			 'name' => 'Geschlecht',
    		 'options' => array(
        		 'label' => '',
        			 'value_options' => array(
            			 'm' => 'männlich',
            			 'w' => 'weiblich',
        				 ),
    				 ),
		));

		$this->add(array(
		 	'type' => 'Zend\Form\Element\Select',
			'name' => 'Werbung',
			'options' => array(
				'label' => '',
					'value_options' => array(
						'1' => 'ja',
						'0' => 'nein',
        				),
    				),
		));

		$this->add(array(
    		'type' => 'Zend\Form\Element\Select',
    		'name' => 'Historie',
    		'options' => array(
        	'label' => '',
        		'value_options' => array(
            		'1' => 'ja',
            		'0' => 'nein',
        			),
    			), 
		));

		$this->add(array(
	 		'name' => 'Umkreis',
			'type' => 'text',
        	'options' => array(
        	'label' => '', 
		// "sollen" war mit "lll" -> editiert von Philipp am 06.12.14
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
             'name' => 'name_athlet_bkih',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             	 ),
         ));
		 	
		$this->add(array(
	 		'name' => 'Email', 
			'type' => 'text',
        	'options' => array(
        	'label' => ' ',
			),
			'attributes' => array(
                		'placeholder' => 'you@domain.de',
            )
			
        ));
			
		$this->add(array(
	 		'name' => 'Passwort',
			'type' => 'password',
        	'options' => array(
        	'label' => '',
			),
        ));
		
		$this->add(array(
	 		'name' => 'pw2_athlet',
			'type' => 'password',
        	'options' => array(
        	'label' => '',
			),
        ));

		$this->add(array(
        	'name' => 'areg',
        	'type' => 'Submit',
			'attributes' => array(
            	'value' => 'Registrieren', // value war auf 'Go' gesetzt, hab ich (Philipp) am 07.12.14 auf 'Registrieren' editiert, weiß nicht, ob der 'value' relevant ist ;)
                'id' => 'submitbutton',
				'class' => 'button'
         		),
         ));
		 
		$this->add(array(
        	'name' => 'aregreset',
        	'type' => 'Submit',
			'attributes' => array(
            	'value' => 'Zurücksetzen',
                'id' => 'submitbutton',
				'class' => 'button'
         		),
         ));
		 
		 
		 
     }
	 
	 
	 /////////////////////////
	 
	 
	 
	 public function getOptionsForVerein()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM verein';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Name'];
        }
    
        return $selectData;
    }
	
	
	 public function getOptionsForMotivation()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM motivation';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Bezeichnung'];
        }
    
        return $selectData;
    }
	
	public function getOptionsForSportart()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM sportart';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Bezeichnung'];
        }
    
        return $selectData;
    }
	
	
	public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

	/**
     * @param field_type $dbAdapter
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
	/**
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }

	/**
     * @param field_type $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

	 
	
 }
?>