<?php
namespace Mitarbeiteransichtveranstalter\Model;

class MitarbeiteransichtveranstalterEntity
{

    protected $id;

    protected $name;
    
    protected $vorname;
    
    protected $email;
    
    protected $iban;
    
    protected $bic;
    
    protected $verifiziert;
    
    protected $firmenname;
    
    protected $strasse;
    
    protected $hausnummer;
    
    protected $postleitzahl;
    
    protected $ort;
    
    

   
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
     * @return the $vorname
     */
    public function getVorname()
    {
        return $this->vorname;
    }

	/**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
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
     * @return the $verifiziert
     */
    public function getVerifiziert()
    {
        return $this->verifiziert;
    }

	/**
     * @return the $firmenname
     */
    public function getFirmenname()
    {
        return $this->firmenname;
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
     * @param field_type $vorname
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

	/**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @param field_type $verifiziert
     */
    public function setVerifiziert($verifiziert)
    {
        $this->verifiziert = $verifiziert;
    }

	/**
     * @param field_type $firmenname
     */
    public function setFirmenname($firmenname)
    {
        $this->firmenname = $firmenname;
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

	public function __construct()
    {
    }
	/**
     * @return the $id
     */
    


    



}