<?php
namespace Vereinsuche\Model;

class Verein
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->adminemail  = (!empty($data['Adminemail'])) ? $data['Adminemail'] : null;
        $this->plz  = (!empty($data['Postleitzahl'])) ? $data['Postleitzahl'] : null;
        $this->ort  = (!empty($data['Ort'])) ? $data['Ort'] : null;
        $this->strasse  = (!empty($data['Strasse'])) ? $data['Strasse'] : null;
        $this->hausnummer  = (!empty($data['Hausnummer'])) ? $data['Hausnummer'] : null;
        $this->email  = (!empty($data['Email'])) ? $data['Email'] : null;
        $this->iban  = (!empty($data['IBAN'])) ? $data['IBAN'] : null;
        $this->bic  = (!empty($data['BIC'])) ? $data['BIC'] : null;
    }
}