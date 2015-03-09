<?php
namespace Starmina\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Starmina\Model\ErgebnisEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class ErgebnisMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'Ergebnis';
    protected $dbAdapter;
    protected $sql;
    protected $service_manager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->service_manager;
    }
    
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

        $entityPrototype = new ErgebnisEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
	
	public function athletfetchAll($athletid) // eingefügt von TW Gruppe7
    {
        $select = $this->sql->select();
        $select->where(array('Athletid' => $athletid));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new ErgebnisEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveErgebnis(ErgebnisEntity $ergebnis, $geburtstag)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($ergebnis);
    
        if (!($ergebnis->getEventid() && $ergebnis->getAthletid())) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('eventid' => $ergebnis->getEventid(), 'eventid' => $ergebnis->getAthletid()));
        } else {
            // insert action
            $action = $this->sql->insert();
            
            
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        echo "<br>";
        echo "Test";
        echo $geburtstag;
            $action2 = $this->dbAdapter->query('UPDATE `ergebnis` SET `Alter`=TIMESTAMPDIFF(YEAR,?,(select Datum from event where id = ?)) WHERE `Eventid` = ? AND `Athletid` = ?', array($geburtstag, $ergebnis->getEventid(), $ergebnis->getEventid(), $ergebnis->getAthletid()));
    
        if (!$ergebnis->getEventid() && !$ergebnis->getAthletid())  {
            $veranstalter->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    public function Ergebnisev($evid, $sort = null)
    {
        $select = $this->sql->select();
        // Grš§er gleich wurde noch nicht umgesetzt!!!
        if($sort == 1)
        {
            $select->where->between('Alter', 0, 4);
        }
        if($sort == 2)
        {
            $select->where->between('Alter', 0, 5);
        }
        if($sort == 3)
        {
            $select->where->between('Alter', 0, 6);
        }
        if($sort == 4)
        {
            $select->where->between('Alter', 0, 9);
        }
        if($sort == 5)
        {
            $select->where->between('Alter', 0, 11);
        }
        if($sort == 6)
        {
            $select->where->between('Alter', 0, 13);
        }
        if($sort == 7)
        {
            $select->where->between('Alter', 0, 18);
        }
        if($sort == 8)
        {
            $select->where->between('Alter', 18, 29);
        }
        if($sort == 9)
        {
            $select->where->between('Alter', 30, 34);
        }
        if($sort == 10)
        {
            $select->where->between('Alter', 35, 39);
        }
        if($sort == 11)
        {
            $select->where->between('Alter', 40, 44);
        }
        if($sort == 12)
        {
            $select->where->between('Alter', 45, 49);
        }
        if($sort == 13)
        {
            $select->where->between('Alter', 50, 54);
        }
        if($sort == 14)
        {
            $select->where->between('Alter', 55, 59);
        }
        if($sort == 15)
        {
            $select->where->between('Alter', 60, 64);
        }
        if($sort == 16)
        {
            $select->where->between('Alter', 65, 69);
        }
        if($sort == 17)
        {
            $select->where->between('Alter', 70, 74);
        }
        if($sort == 18)
        {
            $select->where->between('Alter', 75, 79);
        }
        if($sort == 19)
        {
            $select->where->between('Alter', 80, 200);
        }
        $select->where(array('eventid' => $evid));
        $select->order(array('zeit ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
//         print_r($results);
    
        $entityPrototype = new ErgebnisEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function getErgebnis($id, $athletid)
    {
        echo $athletid;
        $select = $this->sql->select();
        $select->where(array('eventid' => $id,'athletid' => $athletid ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $ergebnis = new ErgebnisEntity();
        $hydrator->hydrate($result, $ergebnis);
    
        print_r($ergebnis);
        return $ergebnis;
    }
    
    public function checkAnzahl($eventid)
    {
        $action = $this->dbAdapter->query('SELECT Count(*) AS anzahl FROM `ergebnis` WHERE `Eventid` = ?', array($eventid));
        $test = $action->toArray();
        $anzahl = $test[0]['anzahl'];
        echo "Anzahl";
        echo $anzahl;
        
        return $anzahl;

    }
    
    public function getGuthaben($athlet)
    {
        $action = $this->dbAdapter->query('SELECT Kontostand AS konto FROM `athlet_guthaben_konto` WHERE `Athletid` = ?', array($athlet->id));
        $test = $action->toArray();
        $konto = $test[0]['konto'];
        if(empty($konto))
        {
            $konto = 0;
        }
        echo "Guthaben";
        echo $konto;
    
        return $konto;
    
    }
    
   
    public function updatePlatzierung($erg)
    {
        $i = 1;
        echo "<br>";
        
        foreach ($erg as $ergebnis)
        {
            echo "Iterator";
            echo $i;
            echo"<br>Event";
            echo $ergebnis->getEventid();
            echo"<br>Athlet";
            echo $ergebnis->getAthletid();
            echo"<br>";
            $action = $this->dbAdapter->query('UPDATE `ergebnis` SET `Gesamtplatzierung`= ?  WHERE `Eventid`=? AND `Athletid`=?', array($i, $ergebnis->getEventid(), $ergebnis->getAthletid()));
            echo $i;
            
            $i++;
        }
    }
    
    public function deleteLogin($Bild)
    {
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE `Email`=?', array($Bild->getEmail()));
        $result = $this->dbAdapter->driver->createResult($action);
        print_r($result);
        return $result;
    }
    
    public function kostenpflichtig($athlet, $event)
    {
        echo "Kostenpflichtig";
        //Durch das Objekt Event wird der Veranstalter geladen
        $action = $this->dbAdapter->query('SELECT a.id AS id FROM `veranstalter`a, `veranstaltung`b, `event`c WHERE a.id = b.veranstalterid AND b.id = c.veranstaltungsid  AND c.id = ?', array($event->getId()));
        $test = $action->toArray();
        $vid = $test[0]['id'];
        
        //Holen des Veranstalter-Objekts
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($vid);
        
        //Buchung Athlet
        $action2 = $this->dbAdapter->query('INSERT INTO `athlet_buchung`(`IBAN`, `BIC`, `Datum`, `Athletid`, `Wert`) VALUES (?,?,NOW(),?,-?)', array($athlet->IBAN, $athlet->BIC, $athlet->id, $event->getAnmeldegebuehr()));
        //Aktualisieren des Guthabens
        $action3 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` - ?) WHERE `Athletid` = ?', array($event->getAnmeldegebuehr(), $athlet->id));
                
        
        //Buchung Veranstalter
        $action4 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $event->getAnmeldegebuehr()));
        
        
    }
    
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
    
}