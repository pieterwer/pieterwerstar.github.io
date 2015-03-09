<?php
namespace Starmina\Model;

class AthletenbezahlungEntity
{

    protected $id;
     
    protected $iban;
    
    protected $bic;
    
    protected $date;
    
    protected $athletid;
    
    protected $wert;
    
    protected $verwendungszweck;
    
    protected $verwendungsart;
       
    protected $anzahlathleten;
    
    protected $wertsum;

   

	/**
     * @return the $anzahlathleten
     */
    public function getAnzahlathleten()
    {
        return $this->anzahlathleten;
    }

	/**
     * @return the $wertsum
     */
    public function getWertsum()
    {
        return $this->wertsum;
    }

	/**
     * @param field_type $anzahlathleten
     */
    public function setAnzahlathleten($anzahlathleten)
    {
        $this->anzahlathleten = $anzahlathleten;
    }

	/**
     * @param field_type $wertsum
     */
    public function setWertsum($wertsum)
    {
        $this->wertsum = $wertsum;
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

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
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
     * @return the $date
     */
    public function getDate()
    {
        return $this->date;
    }

	/**
     * @return the $athletid
     */
    public function getAthletid()
    {
        return $this->athletid;
    }

	/**
     * @return the $wert
     */
    public function getWert()
    {
        return $this->wert;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param field_type $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

	/**
     * @param field_type $athletid
     */
    public function setAthletid($athletid)
    {
        $this->athletid = $athletid;
    }

	/**
     * @param field_type $wert
     */
    public function setWert($wert)
    {
        $this->wert = $wert;
    }

	public function __construct()
    {
    }
	/**
     * @return the $id
     */
    
    
    



}