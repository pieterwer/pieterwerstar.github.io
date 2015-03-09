<?php
namespace Ergebnis\Form;

use Zend\InputFilter\InputFilter;

class ErgebnisFilter extends InputFilter
{

    public function __construct()
    {
        
        $this->add(array(
            'name' => 'srt',
            'required' => false
        ));
        
    }
}