<?php

 namespace Starmina\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class Anschrift
 {
	 public $id;
     public $Strasse;
	 public $Hausnummer;
	 public $Postleitzahl;
	 public $Ort;
	 public $Land;
   	 protected $inputFilter;

     public function exchangeArray($data)
     {
		 $this->id  			= (!empty($data['Athletid'])) ? $data['Athletid'] : null;
		 $this->Strasse  	= (!empty($data['Strasse'])) ? $data['Strasse'] : null;
		 $this->Hausnummer  	= (!empty($data['Hausnummer'])) ? $data['Hausnummer'] : null;
		 $this->Postleitzahl  		= (!empty($data['Postleitzahl'])) ? $data['Postleitzahl'] : null;
		 $this->Ort  		= (!empty($data['Ort'])) ? $data['Ort'] : null;
		 $this->Land  		= (!empty($data['Land'])) ? $data['Land'] : null;       
     }
	 
	  public function getArrayCopy()
     {
         return get_object_vars($this);
     }
	 
	 public function setId($id)
	 {
		 $this->id = $id;
	 }
	
 public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }


    public function getAnschriftInputFilter() {
		$standardFilter = array (
				array (
						'name' => 'StripTags' 
				),
				array (
						'name' => 'StringTrim' 
				) 
		);
		
		$standardValidators = array (
				array (
						'name' => 'StringLength',
						'options' => array (
								'encoding' => 'UTF-8',
								'min' => 1,
								'max' => 25 
						) 
				) 
		);
		
			 
       if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

             $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                 'filters'  => array(
                    array('name' => 'Int'),
                ),
             ));

			 
			  $inputFilter->add ( array (
					'name' => 'Strasse',
					'required' => true,
					'filters' => $standardFilter,
					'validators' => $standardValidators 
			) );	
			 
			 $inputFilter->add(array(
                 'name'     => 'Hausnummer',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'Land',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'Ort',
				  'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => $standardValidators
             ));				
			
		
			 
			$inputFilter->add(array(
                 'name'     => 'Postleitzahl',
                 'required' => true,
                 'filters'  => $standardFilter,
                 'validators' => array(
				 	array(
				 		'name' => 'Digits',
						'options' => array(
							'min' => 4,
							'max' => 10,
							))
						)));
			



             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 
 }