<?php
namespace Betreiber\Model;

class BetreiberEntity
{

    protected $id;

    protected $email;

    protected $vorname;

    protected $name;
    
    protected $Passwort;
    
    protected $rolle;

    
    
/**
     * @return the $rolle
     */
    public function getRolle()
    {
        return $this->rolle;
    }

	/**
     * @param field_type $rolle
     */
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;
    }

	/**
     * @return the $Passwort
     */
    public function getPasswort()
    {
        return $this->Passwort;
    }

	/**
     * @param field_type $Passwort
     */
    public function setPasswort($Passwort)
    {
        $this->Passwort = $Passwort;
    }

	//Getter und Setter
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getVorname()
    {
        return $this->vorname;
    }

    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    

}