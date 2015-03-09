<?php
namespace Bonusbetrag\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BonusbetragForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('bonusbetrag');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'wert',
            'type' => 'number',
            'options' => array(
                'label' => 'Bonus-Cent-Betrag: ',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Neuen Wert speichern',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}