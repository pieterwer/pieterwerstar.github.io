<?php
namespace Anfragen\Model;

class LabelEventZuordnungEntity
{

    protected $eventid;

    protected $labelid;
    
    protected $status;


    public function getEventId()
    {
        return $this->eventid;
    }

    public function getLabelId()
    {
        return $this->labelid;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setEventId($eventid)
    {
        $this->eventid = $eventid;
    }

    public function setLizenz($labelid)
    {
        $this->labelid = $labelid;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }

	public function __construct()
    {
    }    
}