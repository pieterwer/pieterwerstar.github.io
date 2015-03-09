<?php
namespace Vereinsadminaendern\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class VereinsadminaendernForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('vereinsadminaendern');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
             'type' => 'text',
            'options' => array(
                'label' => 'VereinsID:',
            ),
            'attributes' => array(
                'id' => 'name',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'adminemail',
            'type' => 'text',
            'options' => array(
                'label' => 'Adminemail:',
            ),
            'attributes' => array(
                'id' => 'adminemail',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'passwort',
            'type' => 'text',
            'options' => array(
                'label' => 'Passwort:',
            ),
            'attributes' => array(
                'id' => 'passwort',
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