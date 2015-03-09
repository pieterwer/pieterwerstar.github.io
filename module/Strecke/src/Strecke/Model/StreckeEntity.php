<?php
namespace Strecke\Model;

class StreckeEntity
{

    protected $id;  
    
    protected $eventid;  

    protected $streckenlaenge;
    
    
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
     * @return the $streckenlaenge
     */
    public function getStreckenlaenge()
    {
        return $this->streckenlaenge;
    }

	/**
     * @param field_type $streckenlaenge
     */
    public function setStreckenlaenge($streckenlaenge)
    {
        $this->streckenlaenge = $streckenlaenge;
    }
  
    

}