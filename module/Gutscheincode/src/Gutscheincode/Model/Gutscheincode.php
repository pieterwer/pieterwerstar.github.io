<?php
namespace Gutscheincode\Model;
//neu 9.12. 14:05
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
//neu 9.12. 14:05
class Gutscheincode implements InputFilterAwareInterface
{
    public $id;
    public $wert;
    public $status;

    

	public function exchangeArray($data)
    {
        //VERSUCH 9.12. 15:06
        $this->id              =(!empty($data['id'])) ? $data['id'] : null;
        $this->wert            =(!empty($data['wert'])) ? $data['wert'] : null;
        $this->status          =(!empty($data['status'])) ? $data['status'] : null;
    }

 // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();


             $inputFilter->add(array(
                 'name'     => 'wert', 
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'Between',
                         'options' => array(
                             'min' => 1,
                             'max' => 1000,
                         ),
                     ),
                 ),
             ));


             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     
     public function getInputfilterSearch()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();


             $inputFilter->add(array(
                 'name'     => 'id', 
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'Between',
                         'options' => array(
                             'min' => 1,
                             'max' => 99999999999999,
                             
                         ),
                     ),
                 ),
             ));


             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     } 

     public function getInputfilterEinloesen()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();
     
     
             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'Between',
                         'options' => array(
                             'min' => 1,
                             'max' => 99999999999999,
                              
                         ),
                     ),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'athletenid',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                     array(
                         'name' => 'Between',
                         'options' => array(
                             'min' => 1,
                             'max' => 99999999999999,
             
                         ),
                     ),
                 ),
             ));
     
     
             $this->inputFilter = $inputFilter;
         }
     
         return $this->inputFilter;
     }

}
 
 
 
 