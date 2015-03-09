<?php

namespace Gutscheincode\Form;

use Zend\Form\Form;

class GutscheincodeEinloesenForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('gutscheincode');
 
        $this->add(array(
            'name' => 'id',
            'type' => 'Number',
            'options' => array(
                'label' => 'Gutscheincode-ID: ',
            ),
        ));

        $this->add(array(
            'name' => 'athletenid',
            'type' => 'Number',
            'options' => array(
                'label' => 'Athleten-ID: ',
            ),
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
