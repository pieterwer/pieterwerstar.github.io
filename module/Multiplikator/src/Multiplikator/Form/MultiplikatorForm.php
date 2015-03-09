<?php
namespace Multiplikator\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class MultiplikatorForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('Multiplikator');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'anfang',
            'options' => array(
                'label' => 'Beginn: ',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'min' => date('Y-m-d H:i'),
                'step' => '1', // minutes; default step interval is 1 min
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'ende',
            'options' => array(
                'label' => 'Ende: ',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'min' => date('Y-m-d H:i'),
                'step' => '1', // minutes; default step interval is 1 min
            )
        ));
        
        $this->add(array(
            'name' => 'wert',
            'type' => 'text',
            'options' => array(
                'label' => 'Prozentangabe:',
            ),
            'attributes' => array(
                'id' => 'wert',
                'maxlength' => 100,
            )
        ));
        

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'button',
            ),
        ));
    }
}