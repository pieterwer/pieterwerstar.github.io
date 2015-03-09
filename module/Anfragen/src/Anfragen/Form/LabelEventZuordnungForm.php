<?php

namespace Anfragen\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class LabelEventZuordnungForm extends Form
{
    public function __construct($name = null, $options = array())
    {
    parent::__construct('labeleventzuordnung');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name' => 'eventid',
            'type' => 'text',
            'options' => array(
                'label' => 'EventID:',
            ),
            'attributes' => array(
                'id' => 'eventid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'labelid',
            'type' => 'text',
            'options' => array(
                'label' => 'LabelID:'
            ),
            'attributes' => array(
                'id' => 'labelid',
                'value' => 0,
                'min' => 0,
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'status',
            'type' => 'text',
            'options' => array(
                'label' => 'Status:',
            ),
            'attributes' => array(
                'id' => 'status',
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