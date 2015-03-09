<?php
namespace Cashbackmultiplikator\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CashbackmultiplikatorForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('cashbackmultiplikator');

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'freigegeben',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Status: ',
                'empty_option'  => '-Bitte selektieren-',
                'value_options' => array(
                    '0' => '0 - Ablehnen',
                    '1' => '1 - Annehmen')
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Status speichern',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}