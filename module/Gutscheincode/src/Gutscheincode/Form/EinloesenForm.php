<?php

namespace Gutscheincode\Form;

use Zend\Form\Form;

class EinloesenForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('gutscheincode');


	
        $this->add(array(
            'name' => 'id',
            'type' => 'Number',
            'required' => true,
            'options' => array(
                'label' => 'Gutschein Id:',
            ),
        ));
		
		 $this->add(array(
		 	'name' => 'athletenid',
            'type' => 'Hidden',		 
         ));
         

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}