<?php
namespace Pwvergessen\Model;

use Zend\Db\Adapter\Adapter;
use Pwvergessen\Model\PwvergessenEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail;
use Zend\Mail\Transport\Smtp;

class PwvergessenMapper
{
    protected $tableName = 'logindaten';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }
    
    // Setzt das alte Passwort auf das Neue (asdf) in der Logindaten-Tabelle
    public function updatePW(PwvergessenEntity $pwvergessen)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($pwvergessen);
        //var_dump($data);

        $emailadress = $pwvergessen->getEmail();
        
        // Update Befehl in der Event-Tabelle
        $pw = $this->zufallPW(8, '', 3);
        $action = $this->dbAdapter->query('UPDATE `logindaten` SET Passwort = ? WHERE Email = ?', array($pw, $emailadress));
        
        //Email versenden
        $mail = new \Zend\Mail\Message();
        $mail->setBody('Sie haben Ihr altes Starmina Passwort vergessen?<br> Dann haben wir hier ein neues f&uumlr Sie.<br> Hier ist Ihr neues Passwort: 123');
        $mail->setFrom('maringer91@googlemail.com', 'Starmina Sports');
        $mail->addTo($emailadress);
        $mail->setSubject('Starmina - Zugangsdaten - Ihr Neues Passwort');
        $transport = new \Zend\Mail\Transport\Sendmail();
        $transport->send($mail);
        return true;
    }
    
    public function checkEmail(PwvergessenEntity $ea)
    {
        $hydrator = new ClassMethods();
        $date = $hydrator->extract($ea);
        $emailadress = $ea->getEmail();
        $action = $this->dbAdapter->query('SELECT * from `logindaten` WHERE Email = ?', array($emailadress));
        $test = $action->toArray();
        $email = $test[0]['Email'];
        
        return $email;
    }
    
    public function getPwvergessenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('PwvergessenMapper');
    }
    
    public function zufallPW($length, $characters_array, $mode)
    {
        if (!$characters_array)
        {
            $characters_array = array
            (
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',  'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y','z'
            );
        }
        if (!isset($mode))
        {
            $mode = 5;
        }
        $num = array
        (
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        $random = '';
        for ($i = 0; $i < $length; $i++)
        {
            if (rand(1, 10) > $mode)
            {
                $random .= $characters_array[rand(0, count($characters_array) - 1)];
            }
            else
            {
                $random .= $num[rand(0, 9)];
            }
        }
        return $random;
    }
}