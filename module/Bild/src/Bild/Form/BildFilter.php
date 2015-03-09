<?php
namespace Veranstaltung\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BildFilter implements InputFilterAwareInterface
{
    public $bildname;
    public $fileupload;
    protected $inputFilter;
     
    public function exchangeArray($data)
    {
        $this->bildname  = (isset($data['bildname']))  ? $data['bildname']     : null;
        $this->fileupload  = (isset($data['fileupload']))  ? $data['fileupload']     : null;
    }
     
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
     
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
              
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'bildname',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                ))
            );
             
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'fileupload',
                    'required' => true,
                ))
            );
             
            $this->inputFilter = $inputFilter;
        }
         
        return $this->inputFilter;
    }
}