<?php
namespace Kinder\Model;

class KinderEntity
{

    protected $id;

    protected $name;
    
    protected $geburtsdatum;
    
    protected $geschlecht;
    
    protected $athletid;
    
    
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
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @return the $geburtsdatum
     */
    public function getGeburtsdatum()
    {
        return $this->geburtsdatum;
    }

	/**
     * @param field_type $geburtsdatum
     */
    public function setGeburtsdatum($geburtsdatum)
    {
        $this->geburtsdatum = $geburtsdatum;
    }

	/**
     * @return the $geschlecht
     */
    public function getGeschlecht()
    {
        return $this->geschlecht;
    }

	/**
     * @param field_type $geschlecht
     */
    public function setGeschlecht($geschlecht)
    {
        $this->geschlecht = $geschlecht;
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

    
    


}