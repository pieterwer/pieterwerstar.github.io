<?php
namespace Vereinsadminaendern\Model;

class VereinsadminaendernEntity
{

    protected $id;

    protected $adminemail;

    protected $passwort;

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $adminemail
     */
    public function getAdminemail()
    {
        return $this->adminemail;
    }

	/**
     * @return the $passwort
     */
    public function getPasswort()
    {
        return $this->passwort;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $adminemail
     */
    public function setAdminemail($adminemail)
    {
        $this->adminemail = $adminemail;
    }

	/**
     * @param field_type $passwort
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    }

	public function __construct()
    {
    }
	
    
}