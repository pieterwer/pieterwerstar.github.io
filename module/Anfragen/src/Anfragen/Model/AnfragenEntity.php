<?php
namespace Anfragen\Model;

class AnfragenEntity
{

    protected $eventid;

    protected $lizenz;


    public function getEventId()
    {
        return $this->eventid;
    }

    public function getLizenz()
    {
        return $this->lizenz;
    }

    public function setEventId($eventid)
    {
        $this->eventid = $eventid;
    }

    public function setLizenz($lizenz)
    {
        $this->lizenz = $lizenz;
    }

	public function __construct()
    {
    }    
}