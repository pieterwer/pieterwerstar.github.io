<?php
namespace Pwvergessen\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class PwvergessenForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('pwvergessen');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email-Adresse: ',
            ),
        ));
        

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Neues Passwort beantragen',
                'class' => 'button',
            ),
        ));
    }
}