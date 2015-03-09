<?php
namespace Bewertung\Model;

class BewertungEntity
{

    protected $id;

    protected $athletid;

    protected $likert;
    
    protected $eventid;
    
    protected $text;
    
    
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
     * @return the $likert
     */
    public function getLikert()
    {
        return $this->likert;
    }

	/**
     * @param field_type $likert
     */
    public function setLikert($likert)
    {
        $this->likert = $likert;
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
     * @return the $text
     */
    public function getText()
    {
        return $this->text;
    }

	/**
     * @param field_type $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    
    
	


}