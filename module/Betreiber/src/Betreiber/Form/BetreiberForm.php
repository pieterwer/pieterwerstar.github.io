<?php
namespace Betreiber\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BetreiberForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('betreiber');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
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
            'name' => 'passwort',
            'type' => 'text',
            'options' => array(
                'label' => 'Passwort:',
            ),
            'attributes' => array(
                'id' => 'passwort',
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