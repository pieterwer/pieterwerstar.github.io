<?php
namespace Starmina\Model;

class LoginEntity
{


    protected $email;
          
    protected $passwort;    
    
    protected $rolle;
    
    protected $logedin;

   
    public function getLogedin()
    {
        return $this->logedin;
    }

	/**
     * @param field_type $logedin
     */
    public function setLogedin($logedin)
    {
        $this->logedin = $logedin;
    }

	/**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
     * @return the $passwort
     */
    public function getPasswort()
    {
        return $this->passwort;
    }

	/**
     * @return the $rolle
     */
    public function getRolle()
    {
        return $this->rolle;
    }

	/**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

	/**
     * @param field_type $passwort
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    }

	/**
     * @param field_type $rolle
     */
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;
    }

	public function __construct()
    {
    }
	/**
     * @return the $id
     */
   
    
    



}