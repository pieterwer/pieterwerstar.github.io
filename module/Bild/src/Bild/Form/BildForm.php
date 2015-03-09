<?php
namespace Bild\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BildForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('Bild');

        $this->setAttribute('method', 'post' );
        $this->setAttribute('enctype', 'multipart/form-data' );
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());


        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type'  => 'file',
                'max' => 200000,
            ),
            'options' => array(
                'label' => 'File Upload',
            ),
        )); 
        
        $this->add(array(
            'name' => 'bildname',
            'type' => 'text',
            'options' => array(
                'label' => 'Bildname:',
            ),
            'attributes' => array(
                'id' => 'bildname',
                'maxlength' => 100,
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