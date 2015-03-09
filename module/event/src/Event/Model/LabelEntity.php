<?php
namespace Event\Model;

class LabelEntity
{

    protected $id;
    
    protected $labelname;
    
    protected $labelbeschreibung;
    
    protected $bildid;
    
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
     * @return the $labelname
     */
    public function getLabelname()
    {
        return $this->labelname;
    }

	/**
     * @param field_type $labelname
     */
    public function setLabelname($labelname)
    {
        $this->labelname = $labelname;
    }

	/**
     * @return the $labelbeschreibung
     */
    public function getLabelbeschreibung()
    {
        return $this->labelbeschreibung;
    }

	/**
     * @param field_type $labelbeschreibung
     */
    public function setLabelbeschreibung($labelbeschreibung)
    {
        $this->labelbeschreibung = $labelbeschreibung;
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