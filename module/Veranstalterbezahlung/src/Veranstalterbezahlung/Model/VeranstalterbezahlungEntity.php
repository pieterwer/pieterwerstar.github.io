<?php
namespace Veranstalterbezahlung\Model;

class VeranstalterbezahlungEntity
{

    protected $id;

    protected $veranstalterid;
        
    protected $iban;
    
    protected $bic;
    
    protected $wert;
    
    protected $datum;
    
    protected $verwendungszweck;
    
    protected $verwendungsart;
    
   

	

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $veranstalterid
     */
    public function getVeranstalterid()
    {
        return $this->veranstalterid;
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
     * @return the $wert
     */
    public function getWert()
    {
        return $this->wert;
    }

	/**
     * @return the $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }

	/**
     * @return the $verwendungszweck
     */
    public function getVerwendungszweck()
    {
        return $this->verwendungszweck;
    }

	/**
     * @return the $verwendungsart
     */
    public function getVerwendungsart()
    {
        return $this->verwendungsart;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $veranstalterid
     */
    public function setVeranstalterid($veranstalterid)
    {
        $this->veranstalterid = $veranstalterid;
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
     * @param field_type $wert
     */
    public function setWert($wert)
    {
        $this->wert = $wert;
    }

	/**
     * @param field_type $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

	/**
     * @param field_type $verwendungszweck
     */
    public function setVerwendungszweck($verwendungszweck)
    {
        $this->verwendungszweck = $verwendungszweck;
    }

	/**
     * @param field_type $verwendungsart
     */
    public function setVerwendungsart($verwendungsart)
    {
        $this->verwendungsart = $verwendungsart;
    }

	public function __construct()
    {
    }
	

}