<?php
namespace Event\Model;

class SportartEntity
{

    protected $id;

    protected $bezeichnung;
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $bezeichnung
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $bezeichnung
     */
    public function setBezeichnung($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }



}