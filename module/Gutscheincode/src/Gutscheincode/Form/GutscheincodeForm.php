<?php

namespace Gutscheincode\Form;

use Zend\Form\Form;

class GutscheincodeForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('gutscheincode');
 
        $this->add(array(
            'name' => 'wert',
            'type' => 'Number',
            'options' => array(
                'label' => 'Wert',
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
