<?php
namespace Ergebnis\Form;

use Ergebnis\Model\ErgebnisEntity;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ErgebnisFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('ergebnis');

        $this
        ->setHydrator(new ClassMethodsHydrator(false))
        ->setObject(new ErgebnisEntity())
        ;

        $this->setLabel('Ergebnis');

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name of the category',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }
}