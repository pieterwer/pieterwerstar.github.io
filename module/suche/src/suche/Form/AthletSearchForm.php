<?php

namespace Suche\Form;

use Zend\Form\Form;

class AthletSearchForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('athlet');
 

         $this->add(array(
             'name' => 'Name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         
         $this->add(array(
             'name' => 'Vorname',
             'type' => 'Text',
             'default' => 'leer',
             'options' => array(
                 'label' => 'Vorname',
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
