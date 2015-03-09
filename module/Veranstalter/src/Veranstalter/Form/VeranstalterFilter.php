<?php
namespace Veranstalter\Form;

use Zend\InputFilter\InputFilter;

class VeranstalterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
                 'name'     => 'passwort2',
                 'required' => true,
                 'validators' => array(
				 	array(
						'name' => 'StringLength',
						'options' => array(
							'min' => '8',
							'max' => '16'
							)),
					array(
						'name' => 'Identical',
						'options' => array(
						'token' => 'passwort'
							))
				)					
            )
		); 
        
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'logindaten',
                        'field' => 'Email',
                        'adapter' => \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter(),
                    )
                    
                )
            )
            
        ));
	}
}