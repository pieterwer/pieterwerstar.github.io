<?php
namespace Starmina\Model;

class EventkategorieEntity
{

    protected $eventid;

    protected $eventkategorieid;
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
     * @return the $eventkategorieid
     */
    public function getEventkategorieid()
    {
        return $this->eventkategorieid;
    }

	/**
     * @param field_type $eventkategorieid
     */
    public function setEventkategorieid($eventkategorieid)
    {
        $this->eventkategorieid = $eventkategorieid;
    }


	



}