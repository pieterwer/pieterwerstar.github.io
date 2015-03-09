<?php
namespace Werbeauftrag\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class WerbeauftragForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('werbeauftrag');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'label' => 'ID:',
            ),
            'attributes' => array(
                'id' => 'id',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'veranstalterid',
            'type' => 'text',
            'options' => array(
                'label' => 'VeranstalterID:',
            ),
            'attributes' => array(
                'id' => 'veranstalterid',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'label' => 'Name:',
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