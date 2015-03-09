<?php
namespace Hilfe\Model;

class HilfeEntity
{
    public $email;
          
    public $passwort;    
    
    public $rolle;
    
 
    public function getEmail()
    {
        return $this->email;
    }


    public function getPasswort()
    {
        return $this->passwort;
    }


    public function getRolle()
    {
        return $this->rolle;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    }


    public function setRolle($rolle)
    {
        $this->rolle = $rolle;
    }

	public function __construct()
    {
    }
}