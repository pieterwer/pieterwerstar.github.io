<?php
namespace Shop\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class ShopForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('shop');

        $this->setAttribute('method', 'post');
        //$this->setInputFilter(new ErgebnisFilter());
        $this->setHydrator(new ClassMethods());

        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'artikelname',
            'type' => 'text',
            'options' => array(
                'label' => 'Artikelname:',
            ),
            'attributes' => array(
                'id' => 'artikelname',
                'maxlength' => 100,
            )
        ));
        
        $this->add(array(
            'name' => 'artikelpreis',
            'type' => 'text',
            'options' => array(
                'label' => 'Preis:'
            ),
            'attributes' => array(
                'id' => 'artikelpreis',
                'value' => 0,
                'min' => 0,
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
        
        $this->add(array(
            'type' => 'text',
            'name' => 'menge',
            'required' => false,
            'options' => array(
                'label' => 'Menge: '
            ),
                'attributes' => array(
                'id' => 'menge',
                'value' => 1,
                'min' => 1,
                'maxlength' => 100,
                'style' => 'width: 30px; text-align: center;'
            )
        ));
        
    }
}