<?php
namespace Ergebnis\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class ErgebnisForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('ergebnis');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new ErgebnisFilter());
        $this->setHydrator(new ClassMethods());

        
        $this->add(array(
            'name' => 'eventid',
            'type' => 'text',
            'options' => array(
                'label' => 'Event:',
            ),
            'attributes' => array(
                'id' => 'eventid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'athletid',
            'type' => 'text',
            'options' => array(
                'label' => 'Athlet',
            ),
            'attributes' => array(
                'id' => 'athletid',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'zeit',
            'type' => 'text',
            'options' => array(
                'label' => 'Zeit:',
            ),
            'attributes' => array(
                'id' => 'zeit',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'gesamtplatzierung',
            'type' => 'Number',
            'options' => array(
                'label' => 'Gesamtplatzierung',
            ),
            'attributes' => array(
                'id' => 'gesamtplatzierung',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'altersklassenplatzierung',
            'type' => 'Number',
            'options' => array(
                'label' => 'Altersklassenplatzierung',
            ),
            'attributes' => array(
                'id' => 'altersklassenplatzierung',
                'maxlength' => 100,
            )
        ));
        

        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'srt',
            'required' => false,
            'options' => array(
                'label' => 'Filter: ',
                'value_options' => array(
                    'NULL' => 'Filtern nach',
                    '1' => 'Bambini U5',
                    '2' => 'Bambini U6',
                    '3' => 'Bambini U7',
                    '4' => 'Schueler U10',
                    '5' => 'Schueler U12',
                    '6' => 'Schueler U16',
                    '7' => 'Jugend U18',
                    '8' => '18 - 29',
                    '9' => '30 - 34',
                    '10' => '35 - 39',
                    '11' => '40 - 44',
                    '12' => '45 - 49',
                    '13' => '50 - 54',
                    '14' => '55 - 59',
                    '15' => '60 - 64',
                    '16' => '65 - 69',
                    '17' => '70 - 74',
                    '18' => '75 - 90',
                    '19' => '80+',
                    
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
                'class' => 'button',
            ),
        ));
        
    }
}