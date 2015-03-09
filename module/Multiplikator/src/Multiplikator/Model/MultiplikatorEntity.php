<?php
namespace Multiplikator\Model;

class MultiplikatorEntity
{

    protected $id;

    protected $anfang;
    
    protected $ende;
    
    protected $wert;
    
    protected $eventid;
    
    protected $freigegeben;
    
    
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @return the $anfang
     */
    public function getAnfang()
    {
        return $this->anfang;
    }

	/**
     * @param field_type $anfang
     */
    public function setAnfang($anfang)
    {
        $this->anfang = $anfang;
    }

	/**
     * @return the $ende
     */
    public function getEnde()
    {
        return $this->ende;
    }

	/**
     * @param field_type $ende
     */
    public function setEnde($ende)
    {
        $this->ende = $ende;
    }

	/**
     * @return the $wert
     */
    public function getWert()
    {
        return $this->wert;
    }

	/**
     * @param field_type $wert
     */
    public function setWert($wert)
    {
        $this->wert = $wert;
    }

	/**
     * @return the $eventid
     */
    public function getEventid()
    {
        return $this->eventid;
    }

	/**
     * @param field_type $eventid
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;
    }

	/**
     * @return the $freigegeben
     */
    public function getFreigegeben()
    {
        return $this->freigegeben;
    }

	/**
     * @param field_type $freigegeben
     */
    public function setFreigegeben($freigegeben)
    {
        $this->freigegeben = $freigegeben;
    }

    
    
    
}