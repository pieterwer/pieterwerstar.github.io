<?php
namespace Event\Form;

use Zend\InputFilter\InputFilter;

class EventFilter extends InputFilter
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
            'name' => 'kategorien',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'datum',
            'required' => false
        ));
        
        
        $this->add(array(
            'name' => 'zahlungsart',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'geschlechtsbeschraenkung',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'meisterschaftsbeschraenkung',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'Date',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie ein zuk&uuml;nftiges Datum ein. '
                    ),
                    'callback' => function ($value, $context)
                    {
                        if($value <= date("Y-m-d")){
                            if($value <= date("Y-m-d") && $context['Time'] <= date("H:i")){
                            return false;
                            } else {
                                return true;
                            }
                            return false;
                        }
                        return true;
                        
                    }
                ))
            )
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
            'name' => 'altersmaximum',
            'required' => false,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Altersmaximum muss größer oder genaus so groß sein wie das Altersminimum '
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
            'required' => true,
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
            'required' => true,
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