<?php
namespace Athletenhistorie\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class AthletenhistorieForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('athletenhistorie');

        $this->setAttribute('method', 'post');
       // $this->setInputFilter(new EventFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'altersklassenplatzierung',
            'type' => 'text',
            'options' => array(
                'label' => 'Altersklassenplatzierung:',
            )
        ));

        $this->add(array(
            'name' => 'Athletid',
            'type' => 'text',
            'options' => array(
                'label' => 'Athleten ID:',
            ),
            'attributes' => array(
                'id' => 'athletid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'Eventid',
            'type' => 'text',
            'options' => array(
                'label' => 'Eventid:',
            ),
            'attributes' => array(
                'id' => 'Eventid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'platzierung',
            'type' => 'text',
            'options' => array(
                'label' => 'gesamtplatzierung:',
            ),
            'attributes' => array(
                'id' => 'platzierung',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'zeit',
            'type' => 'text',
            'options' => array(
                'label' => 'zeit:',
            ),
            'attributes' => array(
                'id' => 'zeit',
                'maxlength' => 100,
            )
        ));
        
       
}
}