<?php
namespace Athletenbezahlung\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class AthletenbezahlungForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('athletenbezahlung');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'label' => 'ID:',
            ),
            'attributes' => array(
                'id' => 'id',
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
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'date',
            'options' => array(
                'label' => 'Datum: ',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'min' => date('Y-m-d H:i'),
                'step' => '1', // minutes; default step interval is 1 min
            )
        ));
        
        $this->add(array(
            'name' => 'athletid',
            'type' => 'text',
            'options' => array(
                'label' => 'AthletenID:',
            ),
            'attributes' => array(
                'id' => 'athletid',
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
            'name' => 'verwendungsart',
            'type' => 'text',
            'options' => array(
                'label' => 'Verwendungsart:',
            ),
            'attributes' => array(
                'id' => 'verwendungsart',
                'maxlength' => 100,
            )
        ));
        $this->add(array(
            'name' => 'verwendungszweck',
            'type' => 'text',
            'options' => array(
                'label' => 'Verwendungszweck:',
            ),
            'attributes' => array(
                'id' => 'verwendungszweck',
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