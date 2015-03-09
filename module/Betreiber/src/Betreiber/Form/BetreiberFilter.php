<?php
namespace Betreiber\Form;

use Zend\InputFilter\InputFilter;

class BetreiberFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'Int'
                )
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'vorname',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'nachname',
            'required' => false
        ));
    }
}