<?php
namespace Login\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class LoginForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
        'options' => array(
                'label' => 'Email Adresse:',
            ),
            'attributes' => array(
                'id' => 'name',
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
                'id' => 'name',
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
}