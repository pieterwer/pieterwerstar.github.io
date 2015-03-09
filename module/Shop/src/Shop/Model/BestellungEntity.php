<?php
namespace Shop\Model;

class BestellungEntity
{

    protected $id;  
    
    protected $artikelid;  

    protected $status;
    
    protected $datum;
    
    protected $veranstalterid;
    
    protected $menge;
    
    
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
     * @return the $artikelid
     */
    public function getArtikelid()
    {
        return $this->artikelid;
    }

	/**
     * @param field_type $artikelid
     */
    public function setArtikelid($artikelid)
    {
        $this->artikelid = $artikelid;
    }

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
     * @return the $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }

	/**
     * @param field_type $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
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
     * @return the $menge
     */
    public function getMenge()
    {
        return $this->menge;
    }

	/**
     * @param field_type $menge
     */
    public function setMenge($menge)
    {
        $this->menge = $menge;
    }

  
    

}