<?php
namespace Veranstalter\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class VeranstalterForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('veranstalter');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new VeranstalterFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'name',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'vorname',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'vorname',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'email',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'passwort',
            'type' => 'password',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'passwort',
                'minlength' => 8,
                'maxlength' => 100,
            )
        ));
		
		$this->add(array(
            'name' => 'passwort2',
            'type' => 'password',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'passwort2',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'iban',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'iban',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'bic',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'bic',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'verifiziert',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'verifiziert',
                'maxlength' => 100,
            	'style' => 'display: none;'
            )
        ));
        
        $this->add(array(
            'name' => 'firmenname',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'firmenname',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'strasse',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'strasse',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'hausnummer',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'hausnummer',
                'maxlength' => 100,
            	'style' => 'width: 30px; margin-left: 5px;'
            )
        ));
        
        $this->add(array(
            'name' => 'postleitzahl',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'postleitzahl',
                'maxlength' => 100,
            	'style' => 'width: 80px;'
            )
        ));
        
        $this->add(array(
            'name' => 'ort',
            'type' => 'text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'ort',
                'maxlength' => 100,
            	'style' => 'margin-left: 5px;'
            )
        ));
        

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'button',
            ),
        ));
    }
}