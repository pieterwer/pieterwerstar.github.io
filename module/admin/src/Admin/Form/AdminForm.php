<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class AdminForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('admin');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter(new AdminFilter());
        $this->setHydrator(new ClassMethods());
        
   
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email:',
            ),
            'attributes' => array(
                'id' => 'email',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'vorname',
            'type' => 'text',
            'options' => array(
                'label' => 'Vorname:',
            ),
            'attributes' => array(
                'id' => 'vorname',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'nachname',
            'type' => 'text',
            'options' => array(
                'label' => 'Nachname:',
            ),
            'attributes' => array(
                'id' => 'nachname',
                'maxlength' => 100,
            )
        ));  

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
        
        
    }

//Getter und Setter
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