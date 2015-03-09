<?php
namespace Mitarbeitereventansicht\Model;

class MitarbeitereventansichtEntity
{

    protected $id;

    protected $veranstaltungsid;
    
    protected $teilnehmerlimit;
    
    protected $name;
    
    protected $ort;
    
    protected $vorgaengerid;
    
    protected $geschlechtsbeschraenkung;
    
    protected $meisterschaftsbeschraenkung;
    
    protected $anmeldegebuehr;
    
    protected $datum;
    
    protected $postleitzahl;
    
    protected $strasse;
    
    protected $hausnummer;
    
    protected $lizenz;
    
    protected $altersminimum;
    
    protected $altersmaximum;
    

    protected $status;

   
	

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $eranstaltungsid
     */
    public function getVeranstaltungsid()
    {
        return $this->veranstaltungsid;
    }

	/**
     * @return the $teilnehmerlimit
     */
    public function getTeilnehmerlimit()
    {
        return $this->teilnehmerlimit;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $ort
     */
    public function getOrt()
    {
        return $this->ort;
    }

	/**
     * @return the $vorgaengerid
     */
    public function getVorgaengerid()
    {
        return $this->vorgaengerid;
    }

	/**
     * @return the $geschlechtsbeschraenkung
     */
    public function getGeschlechtsbeschraenkung()
    {
        return $this->geschlechtsbeschraenkung;
    }

	/**
     * @return the $meisterschaftsbeschraenkung
     */
    public function getMeisterschaftsbeschraenkung()
    {
        return $this->meisterschaftsbeschraenkung;
    }

	/**
     * @return the $anmeldegebuehr
     */
    public function getAnmeldegebuehr()
    {
        return $this->anmeldegebuehr;
    }

	/**
     * @return the $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }

	/**
     * @return the $postleitzahl
     */
    public function getPostleitzahl()
    {
        return $this->postleitzahl;
    }

	/**
     * @return the $strasse
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

	/**
     * @return the $hausnummer
     */
    public function getHausnummer()
    {
        return $this->hausnummer;
    }

	/**
     * @return the $lizenz
     */
    public function getLizenz()
    {
        return $this->lizenz;
    }

	/**
     * @return the $altersminimum
     */
    public function getAltersminimum()
    {
        return $this->altersminimum;
    }

	/**
     * @return the $altersmaximum
     */
    public function getAltersmaximum()
    {
        return $this->altersmaximum;
    }

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $eranstaltungsid
     */
    public function setEranstaltungsid($eranstaltungsid)
    {
        $this->eranstaltungsid = $eranstaltungsid;
    }

	/**
     * @param field_type $teilnehmerlimit
     */
    public function setTeilnehmerlimit($teilnehmerlimit)
    {
        $this->teilnehmerlimit = $teilnehmerlimit;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

	/**
     * @param field_type $vorgaengerid
     */
    public function setVorgaengerid($vorgaengerid)
    {
        $this->vorgaengerid = $vorgaengerid;
    }

	/**
     * @param field_type $geschlechtsbeschraenkung
     */
    public function setGeschlechtsbeschraenkung($geschlechtsbeschraenkung)
    {
        $this->geschlechtsbeschraenkung = $geschlechtsbeschraenkung;
    }

	/**
     * @param field_type $meisterschaftsbeschraenkung
     */
    public function setMeisterschaftsbeschraenkung($meisterschaftsbeschraenkung)
    {
        $this->meisterschaftsbeschraenkung = $meisterschaftsbeschraenkung;
    }

	/**
     * @param field_type $anmeldegebuehr
     */
    public function setAnmeldegebuehr($anmeldegebuehr)
    {
        $this->anmeldegebuehr = $anmeldegebuehr;
    }

	/**
     * @param field_type $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

	/**
     * @param field_type $postleitzahl
     */
    public function setPostleitzahl($postleitzahl)
    {
        $this->postleitzahl = $postleitzahl;
    }

	/**
     * @param field_type $strasse
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

	/**
     * @param field_type $hausnummer
     */
    public function setHausnummer($hausnummer)
    {
        $this->hausnummer = $hausnummer;
    }

	/**
     * @param field_type $lizenz
     */
    public function setLizenz($lizenz)
    {
        $this->lizenz = $lizenz;
    }

	/**
     * @param field_type $altersminimum
     */
    public function setAltersminimum($altersminimum)
    {
        $this->altersminimum = $altersminimum;
    }

	/**
     * @param field_type $altersmaximum
     */
    public function setAltersmaximum($altersmaximum)
    {
        $this->altersmaximum = $altersmaximum;
    }

	/**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

	public function __construct()
    {
    }
	/**
     * @return the $id
     */
    


    



}