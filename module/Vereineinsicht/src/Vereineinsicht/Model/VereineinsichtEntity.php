<?php
namespace Vereineinsicht\Model;

class VereineinsichtEntity
{

    protected $id;

    protected $name;
    
    protected $adminemail;
    
    protected $iban;
    
    protected $bic;
    
    protected $email;
    
    protected $strasse;
    
    protected $hausnummer;
    
    protected $postleitzahl;
    
    protected $ort;
    
    protected $status;
    
    protected $bankkontoinhaber;
    
    protected $vereinsvertreter;
    

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $adminemail
     */
    public function getAdminemail()
    {
        return $this->adminemail;
    }

	/**
     * @return the $iban
     */
    public function getIban()
    {
        return $this->iban;
    }

	/**
     * @return the $bic
     */
    public function getBic()
    {
        return $this->bic;
    }

	/**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
     * @return the $strasse
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

	/**
     * @return the $hausnummer
     */
    public function getHausnummer()
    {
        return $this->hausnummer;
    }

	/**
     * @return the $postleitzahl
     */
    public function getPostleitzahl()
    {
        return $this->postleitzahl;
    }

	/**
     * @return the $ort
     */
    public function getOrt()
    {
        return $this->ort;
    }

	/**
     * @return the $bankkontoinhaber
     */
    public function getBankkontoinhaber()
    {
        return $this->bankkontoinhaber;
    }

	/**
     * @return the $vereinsvertreter
     */
    public function getVereinsvertreter()
    {
        return $this->vereinsvertreter;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $adminemail
     */
    public function setAdminemail($adminemail)
    {
        $this->adminemail = $adminemail;
    }

	/**
     * @param field_type $iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

	/**
     * @param field_type $bic
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
    }

	/**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

	/**
     * @param field_type $strasse
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

	/**
     * @param field_type $hausnummer
     */
    public function setHausnummer($hausnummer)
    {
        $this->hausnummer = $hausnummer;
    }

	/**
     * @param field_type $postleitzahl
     */
    public function setPostleitzahl($postleitzahl)
    {
        $this->postleitzahl = $postleitzahl;
    }

	/**
     * @param field_type $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

	/**
     * @param field_type $bankkontoinhaber
     */
    public function setBankkontoinhaber($bankkontoinhaber)
    {
        $this->bankkontoinhaber = $bankkontoinhaber;
    }

	/**
     * @param field_type $vereinsvertreter
     */
    public function setVereinsvertreter($vereinsvertreter)
    {
        $this->vereinsvertreter = $vereinsvertreter;
    }

	public function __construct()
    {
    }
	/**
     * @return the $id
     */
    


    



}