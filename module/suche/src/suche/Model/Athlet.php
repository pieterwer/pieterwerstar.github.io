<?php
namespace Suche\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Athlet implements InputFilterAwareInterface
{
    public $Vorname;
    public $Name;
    public $id;
    public $Email;
    public $Titel;
    public $Zusatz;
    public $Geburstag;
    public $Geschlecht;
    public $Telefonnummer;
    public $Fax;
    public $Firma;

    public function exchangeArray($data)
    {
        error_reporting(0);
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->Name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->Vorname  = (!empty($data['Vorname'])) ? $data['Vorname'] : null;
        $this->Email  = (!empty($data['Email'])) ? $data['Email'] : null;
        $this->Titel  = (!empty($data['Titel'])) ? $data['Titel'] : null;
        $this->Zusatz  = (!empty($data['Zusatz'])) ? $data['Zusatz'] : null;
        $this->Geburstag = (!empty($data['Geburtstag'])) ? $data['Geburtstag'] : null;
        $this->Geschlecht = (!empty($data['Geschlecht'])) ? $data['Geschlecht'] : null;
        $this->Telefonnummer = (!empty($data['Telefonnummer1'])) ? $data['Telefonnummer1'] : null;
        $this->Fax = (!empty($data['Fax'])) ? $data['Fax'] : null;
        $this->Firma = (!empty($data['Firma'])) ? $data['Firma'] : null;
        error_reporting(E_ALL);
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
                 'name'     => 'Name',
                 'required' => false,
                 'default' => 'leer', //???
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
             ));
    
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }
    
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
    
    
}