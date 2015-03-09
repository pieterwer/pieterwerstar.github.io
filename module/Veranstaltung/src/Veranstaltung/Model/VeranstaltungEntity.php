<?php
namespace Veranstaltung\Model;

class VeranstaltungEntity
{

    protected $id;

    protected $name;

    protected $vorgaengerid;
    
    protected $veranstalterid;
    
    protected $bildid;
    
    protected $status;
    
    
	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

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
     * @return the $vorgaengerid
     */
    public function getVorgaengerid()
    {
        return $this->vorgaengerid;
    }

	/**
     * @param field_type $vorgaengerid
     */
    public function setVorgaengerid($vorgaengerid)
    {
        $this->vorgaengerid = $vorgaengerid;
    }

	/**
     * @return the $veranstalterid
     */
    public function getVeranstalterid()
    {
        return $this->veranstalterid;
    }

	/**
     * @param field_type $veranstalterid
     */
    public function setVeranstalterid($veranstalterid)
    {
        $this->veranstalterid = $veranstalterid;
    }

	/**
     * @return the $bildid
     */
    public function getBildid()
    {
        return $this->bildid;
    }

	/**
     * @param field_type $bildid
     */
    public function setBildid($bildid)
    {
        $this->bildid = $bildid;
    }

    





}