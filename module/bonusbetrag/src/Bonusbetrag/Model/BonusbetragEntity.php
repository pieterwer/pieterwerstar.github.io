<?php
namespace Bonusbetrag\Model;

class BonusbetragEntity
{

    public $id;

    public $anfang;

    public $ende;
    
    public $wert;
    
    public $eventid;
    
    public $freigegeben;


    public function getId()
    {
        return $this->id;
    }

    public function getAnfang()
    {
        return $this->anfang;
    }

    public function getEnde()
    {
        return $this->ende;
    }

    public function getWert()
    {
        return $this->wert;
    }

    public function getEventId()
    {
        return $this->eventid;
    }
    
    public function getFreigegeben()
    {
        return $this->freigegeben;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAnfang($anfang)
    {
        $this->anfang = $anfang;
    }
    
    public function setEnde($ende)
    {
        $this->ende = $ende;
    }

    public function setWert($wert)
    {
        $this->wert = $wert;
    }
    
    public function setEventId($eventid)
    {
        $this->eventid = $eventid;
    }
    
    public function setFreigegeben($freigegeben)
    {
        $this->freigegeben = $freigegeben;
    }
    
	public function __construct()
    {
    }
	
    
}