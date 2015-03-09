<?php
namespace Lizenz\Model;

class LizenzEntity
{

    public $eventid;

    public function getEventId()
    {
        return $this->eventid;
    }

    public function setEventId($eventid)
    {
        $this->eventid = $eventid;
    }

	public function __construct()
    {
    }    
}