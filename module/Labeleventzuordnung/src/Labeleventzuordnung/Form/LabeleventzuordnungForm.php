<?php

namespace Labeleventzuordnung\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;

class LabeleventzuordnungForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('labeleventzuordnung');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name' => 'status',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Status: ',
                'empty_option'  => '-Bitte selektieren-',
                'value_options' => array(
                    '0' => '0 - Ablehnen',
                    '1' => '1 - Annehmen')
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Status speichern',
                'class' => 'btn btn-primary',
            ),
        ));        
    }
    
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
    
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
    }
}