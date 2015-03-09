<?php
namespace Strecke\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class StreckeForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('ergebnis');

        $this->setAttribute('method', 'post');
        //$this->setInputFilter(new ErgebnisFilter());
        $this->setHydrator(new ClassMethods());

        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'eventid',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'eventid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'streckenlaenge',
            'type' => 'number',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'streckenlaenge',
                'placeholder' => '0.00',
                'min' => 0,
                'step' => 0.01,
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