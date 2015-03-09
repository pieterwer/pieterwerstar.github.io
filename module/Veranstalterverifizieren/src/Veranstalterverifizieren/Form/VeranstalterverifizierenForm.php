<?php

namespace Veranstalterverifizieren\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;

class VeranstalterverifizierenForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('veranstalterverifizieren');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setHydrator(new ClassMethods());
 
        $this->add(array(
            'name' => 'veranstalterid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Veranstalter: ',
                'value_options' => $this->getVeranstalterIDs(),
                'empty_option'  => '-Bitte selektieren-'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Veranstalter verifizieren',
                'class' => 'button',
            ),
        ));
    }
    
    public function getVeranstalterIDs()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM veranstalter WHERE Verifiziert = 0';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = ($res['id'] . ' - ' .$res['Vorname']  . ' ' . $res['Name']);
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
