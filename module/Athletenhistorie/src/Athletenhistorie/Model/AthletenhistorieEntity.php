<?php
namespace Athletenhistorie\Model;

class AthletenhistorieEntity
{

    protected $altersklassenplatzierung;

    protected $athletid;

    protected $eventid;

    protected $gesamtplatzierung;
        
    protected $zeit;
    
    protected $name;
    
    

	

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return the $altersklassenplatzierung
     */
    public function getAltersklassenplatzierung()
    {
        return $this->altersklassenplatzierung;
    }

	/**
     * @return the $athletid
     */
    public function getAthletid()
    {
        return $this->athletid;
    }

	/**
     * @return the $eventid
     */
    public function getEventid()
    {
        return $this->eventid;
    }

	/**
     * @return the $platzierung
     */
    

	/**
     * @return the $zeit
     */
    public function getZeit()
    {
        return $this->zeit;
    }

	/**
     * @param field_type $altersklassenplatzierung
     */
    public function setAltersklassenplatzierung($altersklassenplatzierung)
    {
        $this->altersklassenplatzierung = $altersklassenplatzierung;
    }

	/**
     * @param field_type $athletid
     */
    public function setAthletid($athletid)
    {
        $this->athletid = $athletid;
    }

	/**
     * @param field_type $eventid
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;
    }

	/**
     * @param field_type $platzierung
     */
    

	/**
     * @param field_type $zeit
     */
    public function setZeit($zeit)
    {
        $this->zeit = $zeit;
    }

	public function __construct()
    {
    }
	
    
    



}