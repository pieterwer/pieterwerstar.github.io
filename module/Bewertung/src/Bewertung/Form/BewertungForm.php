<?php
namespace Bewertung\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BewertungForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('Bewertung');

        $this->setAttribute('method', 'post' );
        $this->setAttribute('enctype', 'multipart/form-data' );
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());


        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'athletid',
            'type' => 'text',
            'options' => array(
                'label' => 'Athlet:',
            ),
            'attributes' => array(
                'id' => 'athletid',
            )
        ));
        
        $this->add(array( 
            'name' => 'likert', 
            'type' => 'Zend\Form\Element\Radio', 
            'attributes' => array( 
                'required' => 'required', 
                'value' => '0', 
            ), 
            'options' => array( 
                'label' => 'Sterne', 
                'value_options' => array(
                    '1' => '1', 
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ),
            ), 
        )); 
        

        $this->add(array(
            'name' => 'eventid',
            'type' => 'text',
            'options' => array(
                'label' => 'EventId:',
            ),
            'attributes' => array(
                'id' => 'eventid',
                'maxlength' => 100,
            )
        ));
        
        
        $this->add(array(
            'name' => 'text',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Text:',
            ),
            'attributes' => array(
                'id' => 'text',
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