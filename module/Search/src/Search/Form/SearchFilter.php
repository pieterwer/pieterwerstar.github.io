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
                            'max' => 100,
                            'messages' => array( 
                                'stringLengthTooLong' => 'Bitte geben Sie einen Namen mit weniger als 100 Zeichen ein!' 
                            )
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
                        'messages' => array(
                            'noRecordFound' => 'Bitte geben Sie eine korrekte Postleitzahl ein.',
                        ),
                        'adapter' => \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()
                    )
                    
                )
            )
            
        ));
    }
}