<?php

namespace Anfragen\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class AnfragenForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        // we want to ignore the name passed
        parent::__construct('anfragen');
        
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
 
        $this->add(array(
            'name' => 'eventid',
            'type' => 'number',
            'options' => array(
                'label' => 'Event-ID',
            ),
        ));
        
        $this->add(array(
           'name' => 'lizenz' ,
           'type' => 'number',
           'options' => array(
                'label' => 'Lizenz'
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
}
