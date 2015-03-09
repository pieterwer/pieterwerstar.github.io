<?php
namespace Bewertung\Model;

class AvgbewertungEntity
{

    protected $eventid;

    protected $avg;
    
    
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
     * @return the $avg
     */
    public function getAvg()
    {
        return $this->avg;
    }

	/**
     * @param field_type $avg
     */
    public function setAvg($avg)
    {
        $this->avg = $avg;
    }

    
    





}