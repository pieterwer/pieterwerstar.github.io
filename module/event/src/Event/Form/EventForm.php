<?php
namespace Event\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class EventForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('event');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name'    => 'sportart',
            'type'    => 'Zend\Form\Element\Select',
            'options' => array(
                'label'         => '',
                'value_options' => $this->getOptionsForSportart(),
                'empty_option'  => '--- please choose ---'
            )
        ));
        
        $this->add(array(
            'name'    => 'kategorien',
            'type'    => 'Zend\Form\Element\MultiCheckbox',
            'required' => false,
            'options' => array(
                'label'         => '',
                'value_options' => $this->getOptionsForKategorien()
            )
        ));
        
        $this->add(array(
            'name'    => 'meisterschaftsbeschraenkung',
            'type'    => 'Zend\Form\Element\Select',
            'required' => false,
            'options' => array(
                'label'         => '',
                'value_options' => $this->getOptionsForBegrenzung(),
                'empty_option'  => '--- Bundeslaender ---'
            )
        ));
        
        $this->add(array(
            'name'    => 'Date',
            'type'    => 'Zend\Form\Element\Date',
            'options' => array(
                'label'         => '',
                'format' => 'Y-m-d'
            ),
            'attributes' => array(
                'id' => '',
                'min' => date('Y-m-d'),
                'step' => '1', // minutes; default step interval is 1 min
            )
        ));
        
        $this->add(array(
            'name'    => 'Time',
            'type'    => 'Zend\Form\Element\Time',
            'options' => array(
                'label'         => '',
                'format' => 'H:i'
            ),
            'attributes' => array(
                'id' => 'Time',
                'placeholder' => time(),
                )
        ));
        
        $this->add(array(
            'name'    => 'altersminimum',
            'type' => 'Number',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'id' => 'altersminimum',
                'value' => 0,
                'min' => 0,
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name'    => 'altersmaximum',
            'type' => 'Number',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'id' => 'altersmaximum',
                'value' => 0,
                'min' => 0,
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'vorgaengerid',
            'type' => 'hidden',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'vorgaengerid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'veranstaltungsid',
            'type' => 'hidden',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'veranstaltungsid',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'anmeldegebuehr',
            'type' => 'number',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'id' => 'anmeldegebuehr',
                'placeholder' => '0.00',
                'min' => 0,
                'step' => 0.01,
            )
        ));
        
        $this->add(array(
            'name' => 'teilnehmerlimit',
            'type' => 'Number',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'teilnehmerlimit',
                'min' => 0,
                'max' => 100
            )
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'id' => 'name',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'ort',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'ort',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'postleitzahl',
            'type' => 'text',
            'options' => array(
                'label' => ' ',
            ),
            'attributes' => array(
                'id' => 'postleitzahl',
                'minlength' => 5,
                'maxlength' => 5,
            )
        ));
        
        $this->add(array(
            'name' => 'strasse',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'strasse',
                'maxlength' => 50,
            )
        ));
        
        $this->add(array(
            'name' => 'hausnummer',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'hausnummer',
                'maxlength' => 5,
            )
        ));

        
        $this->add(array(
            'name' => 'beschreibung',
            'type' => 'textarea',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'beschreibung',
                'maxlength' => 1000,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'geschlechtsbeschraenkung',
            'options' => array(
                'label' => '',
                'value_options' => array(
                    NULL => 'Waehle das Geschlecht aus',
                    'w' => 'Weiblich',
                    'm' => 'Maennlich'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'datum',
            'options' => array(
                'label' => '',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'id' => 'datum',
                'min' => date('Y-m-d H:i'),
                'step' => '1', // minutes; default step interval is 1 min
            )
        ));
        

        $this->add(array(
            'name'    => 'zahlungsart',
            'type'    => 'Zend\Form\Element\Radio',
            'options' => array(
                'label'         => '',
                'value_options' => array('0'=> 'Lastschrift', '1' => 'Guthaben'),
                'empty_option'  => '--- please choose ---'
            )
        ));
        /*
        $this->add(array(
            'name'    => 'kinder',
            'type'    => 'Zend\Form\Element\MultiCheckbox',
            'required' => false,
            'options' => array(
                'label'         => 'kinder: ',
                'value_options' => $this->getOptionsForKinder()
            )
        ));
        */
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'button',
            ),
        ));
        
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
    
    public function getOptionsForKategorien()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM eventkategorie';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Eventart'];
        }
    
        return $selectData;
    }
    
    public function getOptionsForBegrenzung()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM state';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['name'];
        }
    
        return $selectData;
    }
	/**
     * @return the $dbAdapter
     */
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