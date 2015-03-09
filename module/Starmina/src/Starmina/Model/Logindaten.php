<?php

namespace Starmina\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Logindaten {
	public $Email;
	public $Passwort;
	public $Rolle;
	public $pw2_athlet;
	public $loginemail_verein;
	public $pw1_verein;
	public $pw2_verein;
	protected $inputFilter;
	public function exchangeArray($data) {
		$this->Email = (! empty ( $data ['Email'] )) ? $data ['Email'] : null;
		$this->Rolle = (! empty ( $data ['Rolle'] )) ? $data ['Rolle'] : null;
		$this->Passwort = (! empty ( $data ['Passwort'] )) ? $data ['Passwort'] : 'asdf1234';
		$this->pw2_athlet = (! empty ( $data ['pw2_athlet'] )) ? $data ['pw2_athlet'] : null;
		$this->loginemail_verein = (! empty ( $data ['Adminemail'] )) ? $data ['Adminemail'] : null;
		$this->pw1_verein = (! empty ( $data ['pw1_verein'] )) ? $data ['pw1_verein'] : null;
		$this->pw2_verein = (! empty ( $data ['pw2_verein'] )) ? $data ['pw2_verein'] : null;
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	
	// !!!!! setIF + get IF wieder zurück in die Athlet.php + Verein.php (PR, 12.12.14)
	
	/*
	 * public function setInputFilter(InputFilterInterface $inputFilter)
	 * {
	 * throw new \Exception("Not used");
	 * }
	 *
	 * public function getInputFilter()
	 * {
	 * $standardFilter = array(
	 * array('name' => 'StripTags'),
	 * array('name' => 'StringTrim'),
	 * );
	 *
	 * $standardValidators = array(
	 * array(
	 * 'name' => 'StringLength',
	 * 'options' => array(
	 * 'encoding' => 'UTF-8',
	 * 'min' => 1,
	 * 'max' => 100,
	 * ),
	 * ));
	 *
	 * if (!$this->inputFilter) {
	 * $inputFilter = new InputFilter();
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'email_athlet',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'pw1_athlet',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'pw2_athlet',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 *
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'loginemail_verein',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'pw1_verein',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 *
	 * $inputFilter->add(array(
	 * 'name' => 'pw2_verein',
	 * 'required' => true,
	 * 'filters' => $standardFilter,
	 * 'validators' => $standardValidators
	 * ));
	 * $this->inputFilter = $inputFilter;
	 * }
	 *
	 * return $this->inputFilter;
	 * }
	 */
}