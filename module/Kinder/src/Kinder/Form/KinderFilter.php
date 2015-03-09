<?php
namespace Kinder\Form;

use Zend\InputFilter\InputFilter;

class KinderFilter extends InputFilter
{

    public function __construct()
    {
        
        $this->add(array(
            'name' => 'zahlungsart',
            'required' => false
        ));
        
    }
}