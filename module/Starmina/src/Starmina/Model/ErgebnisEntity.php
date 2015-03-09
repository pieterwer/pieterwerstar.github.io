<?php
namespace Starmina\Model;

class ErgebnisEntity
{

    protected $eventid;  //eventid

    protected $athletid;

    protected $zeit;
    
    protected $gesamtplatzierung;
    
    protected $altersklassenplatzierung;
        
    protected $alter;
    
    

    public function getAlter()
    {
        return $this->alter;
    }

	/**
     * @param field_type $alter
     */
    public function setAlter($alter)
    {
        $this->alter = $alter;
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
     * @return the $athletid
     */
    public function getAthletid()
    {
        return $this->athletid;
    }

	/**
     * @param field_type $athletid
     */
    public function setAthletid($athletid)
    {
        $this->athletid = $athletid;
    }

	/**
     * @return the $zeit
     */
    public function getZeit()
    {
        return $this->zeit;
    }

	/**
     * @param field_type $zeit
     */
    public function setZeit($zeit)
    {
        $this->zeit = $zeit;
    }

	/**
     * @return the $gesamtplatzierung
     */
    public function getGesamtplatzierung()
    {
        return $this->gesamtplatzierung;
    }

	/**
     * @param field_type $gesamtplatzierung
     */
    public function setGesamtplatzierung($gesamtplatzierung)
    {
        $this->gesamtplatzierung = $gesamtplatzierung;
    }

	/**
     * @return the $altersklassenatzierung
     */
    public function getAltersklassenplatzierung()
    {
        return $this->altersklassenplatzierung;
    }

	/**
     * @param field_type $altersklassenatzierung
     */
    public function setAltersklassenplatzierung($altersklassenplatzierung)
    {
        $this->altersklassenplatzierung = $altersklassenplatzierung;
    }

	public function __construct()
    {
    }



}