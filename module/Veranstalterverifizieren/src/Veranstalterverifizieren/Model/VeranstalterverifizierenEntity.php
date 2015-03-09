<?php
namespace Veranstalterverifizieren\Model;

class VeranstalterverifizierenEntity
{

    public $veranstalterid;

    public function getVeranstalterId()
    {
        return $this->veranstalterid;
    }

    public function setVeranstalterId($veranstalterid)
    {
        $this->veranstalterid = $veranstalterid;
    }

	public function __construct()
    {
    }    
}