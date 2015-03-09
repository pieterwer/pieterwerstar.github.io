<?php
namespace Bewertung\Model;

use Zend\Db\Adapter\Adapter;
use Bewertung\Model\BewertungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class BewertungMapper
{
    protected $tableName = 'Bewertung';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        //$select->order(array('completed ASC', 'created ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new BewertungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveBewertung(BewertungEntity $bewertung)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($bewertung);
    
        if ($bewertung->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $bewertung->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$bewertung->getId()) {
            $bewertung->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    public function saveLogin(BildEntity $Bild, $passwort)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($Bild);
        // Vielleicht †berprŸfung: Meldung
        if ($Bild->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $Bild->getId()));
        } else {
            // insert action
//             unset($data['id']);
//             $action->values($data);
            $action = $this->dbAdapter->query('INSERT INTO `logindaten`(`Email`, `Passwort`, `Rolle`) VALUES (?,?,?)', array($Bild->getEmail(),'Passwort',$this->tableName));
        }
//         $statement = $this->sql->prepareStatementForSqlObject($action);
//         $result = $statement->execute();
    
//         if (!$Bild->getId()) {
//             $Bild->setId($result->getGeneratedValue());
//         }
        return $result;
    
    }
    
    public function Bewertungev($evid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $evid));
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new BewertungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function Bewertungprofil($evid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $evid));
        $select->order(array('id DESC'));
        $select->limit(3);
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new BewertungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function Bewertungveranstaltung($vid)
    {
        
        $action = $this->dbAdapter->query('SELECT `id` FROM `bewertung` WHERE `Eventid` IN (SELECT id FROM `event` WHERE `Veranstaltungsid` = ?) ORDER BY `id` DESC', array($vid));
        $test = $action->toArray();
        if(count($test)<1){
            return null;            
        }
        $avg = $test[0]['id'];
        return $test;

    }
    
    public function getBewertung($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $Bewertung = new BewertungEntity();
        $hydrator->hydrate($result, $Bewertung);
    
        return $Bewertung;
    }
    
    public function getExistBewertung($athletid, $eventid)
    {
        $select = $this->sql->select();
        $select->where(array('athletid' => $athletid, 'eventid' => $eventid));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $Bewertung = new BewertungEntity();
        $hydrator->hydrate($result, $Bewertung);
    
        return $Bewertung;
    }
    
    public function getDurchschnitt($eventid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $eventid));
        //$select->order(array('completed ASC', 'created ASC'));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        
        $action = $this->dbAdapter->query('SELECT Round(Avg(likert),2) AS avg FROM `bewertung` WHERE eventid = ?', array($eventid));
//         print_r($action);
        $test=$action->toArray();
        $avg = $test[0]['avg'];
        return $avg;
    }
    
    public function getVeranstaltung($events)
    {
        $bewertung = 0;
        $i = 0;
        foreach($events as $event)
        {
            $x = $this->getDurchschnitt($event->getId());
            $bewertung = $bewertung + $x;
            $i++;
        }
        if($i == 0){
            return 0;
        }
        $bewertung = $bewertung/$i;
        $bewertung = round($bewertung,2);
        
        return $bewertung;
    }
    
    public function getSterne($var)
    {

        if($var == 0)
        {
            return $star = "0S.png";
        }
        if($var == 1)
        {
            return $star = "1S.png";
        }
        if($var == 2)
        {
            return $star = "2S.jpg";
        }
        if($var == 3)
        {
            return $star = "3S.jpg";
        }
        if($var == 4)
        {
            return $star = "4S.png";
        }
        if($var == 5)
        {
            return $star = "5S.png";
        }
    
    }
    
    public function createlink($bewertung)
    {
            //Bild fŸr die Sternebewertung holen
            $var = round($bewertung);
            $stern = $this->getSterne($var);
            $link = "../../pictures/";
            $link .= $stern;
            
            return $link;
    }
    
    public function createlink3($bewertung)
    {
        //Bild fŸr die Sternebewertung holen
        $var = round($bewertung);
        $stern = $this->getSterne($var);
        $link = "../../../pictures/";
        $link .= $stern;
    
        return $link;
    }
    
    public function deleteBild($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function deleteLogin($Bild)
    {
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE `Email`=?', array($Bild->getEmail()));
        return $result;
    }
    
}