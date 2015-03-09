<?php

namespace Lizenz\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;

class LizenzForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('lizenz');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setHydrator(new ClassMethods());
 
        $this->add(array(
            'name' => 'eventid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Event: ',
                'value_options' => $this->getEventIDs(),
                'empty_option'  => '-Bitte selektieren-'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Lizenz eintragen',
                'class' => 'btn btn-primary',
            ),
        ));
    }
    
    public function getEventIDs()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM event WHERE Lizenz IS NULL';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = ($res['id'] . ' - ' . $res['Name']);
        }
    
        return $selectData;
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
