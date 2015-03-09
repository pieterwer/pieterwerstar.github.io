<?php
namespace Search\Form;

use Zend\InputFilter\InputFilter;

class SearchFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'id',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'Int'
                )
            )
        ));
        
        $this->add(array(
            'name' => 'kategorien',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'sportarten',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'teilnehmerlimit',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'altersminimum',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'umkreis',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'altersmaximum',
            'required' => false,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Altersmaximum muss größer oder genaus so groß sein wie Altersminimum '
                    ),
                    'callback' => function ($value, $context)
                    {
                        return $value >= $context['altersminimum'];
                    }
                ))
            )
        ));
        
        $this->add(array(
            'name' => 'name',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 100
                    )
                )
            )
        ));
        $this->add(array(
            'name' => 'postleitzahl',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\RecordExists',
                    'options' => array(
                        'table' => 'zipcode',
                        'field' => 'zipcode',
                        'adapter' => \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()
                    )
                    
                )
            )
            
        ));
    }
}