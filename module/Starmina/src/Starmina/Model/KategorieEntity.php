<?php
namespace Starmina\Model;

class KategorieEntity
{

    protected $id;

    protected $eventart;
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $eventart
     */
    public function getEventart()
    {
        return $this->eventart;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $eventart
     */
    public function setEventart($eventart)
    {
        $this->eventart = $eventart;
    }


}