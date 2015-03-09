<?php
namespace Kinder\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class KinderForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('kinder');

        $this->setAttribute('method', 'post');
        //$this->setInputFilter(new ErgebnisFilter());
        $this->setHydrator(new ClassMethods());
        $this->setInputFilter(new KinderFilter());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
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
            'name'    => 'geburtsdatum',
            'type'    => 'Zend\Form\Element\Date',
            'options' => array(
                'label'         => 'Tag: ',
                'format' => 'Y-m-d'
            ),
            'attributes' => array(
                'id' => '',
                'max' => date('Y-m-d'),
                'step' => '1', // day; default step interval is 1 min
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'geschlecht',
            'options' => array(
                'label' => 'Geschlecht: ',
                'value_options' => array(
                    'w' => 'Weiblich',
                    'm' => 'Maennlich'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
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
        
        
        $this->add(array(
            'name'    => 'zahlungsart',
            'type'    => 'Zend\Form\Element\Radio',
            'options' => array(
                'label'         => 'Zahlungsart auswaehlen: ',
                'value_options' => array('0'=> 'Lastschrift', '1' => 'Guthaben'),
                'empty_option'  => '--- please choose ---'
            )
        ));
        
    }
}