<?php

// AthletRegistrierungForm ergänzt / angepasst von Philipp am 06.12.14

namespace Starmina\Form;
use Zend\InputFilter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Form\Element;

 use Zend\Form\Form;

 class AnschriftForm extends Form
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
             'name' => 'Strasse',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Straße: ',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Hausnummer',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Hausnummer: ',
         		 ),
         ));
		 
		 $this->add(array(
             'name' => 'Postleitzahl',
             'type' => 'Text',
             'options' => array(
                 'label' => 'PLZ: ',
             	 ),
         ));
		 
		 $this->add(array(
             'name' => 'Ort',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Ort: ',
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
        		 'label' => 'Bitte Land auswählen: ',
        			 'value_options' => array(
            			 'DE' => 'Deutschland ',
            			 'OE' => 'Österreich ',
						 'SW' => 'Schweiz ',
        				 ),
    				 ),
		));
		 
		

		$this->add(array(
        	'name' => 'areg',
        	'type' => 'Submit',
			'attributes' => array(
            	'value' => 'Registrieren', // value war auf 'Go' gesetzt, hab ich (Philipp) am 07.12.14 auf 'Registrieren' editiert, weiß nicht, ob der 'value' relevant ist ;)
                'id' => 'submitbutton',
         		),
         ));
		 
		$this->add(array(
        	'name' => 'aregreset',
        	'type' => 'Submit',
			'attributes' => array(
            	'value' => 'Zurücksetzen',
                'id' => 'submitbutton',
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