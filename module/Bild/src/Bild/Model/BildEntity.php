<?php
namespace Bild\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Form\Annotation\Options;

class BildEntity implements InputFilterAwareInterface
{

    protected $id;

    protected $link;

    protected $bildname;

    protected $inputFilter;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     *
     * @param field_type $link            
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     *
     * @return the $bildname
     */
    public function getBildname()
    {
        return $this->bildname;
    }

    /**
     *
     * @param field_type $bildname            
     */
    public function setBildname($bildname)
    {
        $this->bildname = $bildname;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'fileupload',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
//                     array(
//                         'name' => '\Zend\Validator\File\Extension',
//                         'options' => array(
//                             'case' => false, // Validate case sensitive
//                             'extension' => 'gif,jpg,jpeg,png'
//                         ) // List of extensions

//                     ),
//                     array(
//                         'name' => '\Zend\Validator\File\Size',
//                         'options' => array(
//                             'max' => 2000000
//                         )
//                     ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100
                        )
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'fileupload',
                'required' => true
            )));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }

    public function exchangeArray($data)
    {
        $this->bildname = (isset($data['bildname'])) ? $data['bildname'] : null;
    }
}