<?php
namespace Shop\Model;

class ShopEntity
{

    protected $id;  
    
    protected $artikelname;  

    protected $artikelpreis;

    protected $artikelbildid;
    
    
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
     * @return the $artikelname
     */
    public function getArtikelname()
    {
        return $this->artikelname;
    }

	/**
     * @param field_type $artikelname
     */
    public function setArtikelname($artikelname)
    {
        $this->artikelname = $artikelname;
    }

	/**
     * @return the $artikelpreis
     */
    public function getArtikelpreis()
    {
        return $this->artikelpreis;
    }

	/**
     * @param field_type $artikelpreis
     */
    public function setArtikelpreis($artikelpreis)
    {
        $this->artikelpreis = $artikelpreis;
    }

	/**
     * @return the $artikelbildid
     */
    public function getArtikelbildid()
    {
        return $this->artikelbildid;
    }

	/**
     * @param field_type $artikelbildid
     */
    public function setArtikelbildid($artikelbildid)
    {
        $this->artikelbildid = $artikelbildid;
    }

    
    
	
    
}