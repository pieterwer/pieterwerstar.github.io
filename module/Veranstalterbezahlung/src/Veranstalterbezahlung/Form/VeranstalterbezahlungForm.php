<?php
namespace Vereinbezahlung\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class VereinbezahlungForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('vereinbezahlung');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'label' => 'Name:',
            ),
            'attributes' => array(
                'id' => 'name',
                'maxlength' => 100,
            )
        ));

        
        $this->add(array(
            'name' => 'iban',
            'type' => 'text',
            'options' => array(
                'label' => 'IBAN:',
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
                'label' => 'BIC:',
            ),
            'attributes' => array(
                'id' => 'bic',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'vereinid',
            'type' => 'text',
            'options' => array(
                'label' => 'VereinID:',
            ),
            'attributes' => array(
                'id' => 'vereinid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'wert',
            'type' => 'text',
            'options' => array(
                'label' => 'Wert:',
            ),
            'attributes' => array(
                'id' => 'wert',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'datum',
            'type' => 'text',
            'options' => array(
                'label' => 'Datum:',
            ),
            'attributes' => array(
                'id' => 'datum',
                'maxlength' => 100,
            )
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}