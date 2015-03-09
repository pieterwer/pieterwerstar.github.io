<?php
namespace Ergebnis\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Ergebnis\Model\ErgebnisEntity;
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
    public function athletfetchAll($athletid) 
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
    
    public function updateTime(ErgebnisEntity $ergebnis = null){
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($ergebnis);
        
        // update action
        $action = $this->sql->update();
        $action->set($data);
        $action->where(array('eventid' => $ergebnis->getEventid(), 'athletid' => $ergebnis->getAthletid()));
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        return $result->getAffectedRows();
    }
    
    public function saveErgebnis(ErgebnisEntity $ergebnis)
    {
        $hydrator = new ClassMethods();
        $ergebnis->setAlter(0);
        $data = $hydrator->extract($ergebnis);
    
        if (!($ergebnis->getEventid() && $ergebnis->getAthletid())) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('eventid' => $ergebnis->getEventid(), 'athletid' => $ergebnis->getAthletid()));
        } else {
            // insert action
            $action = $this->sql->insert();
            
            
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
            $action2 = $this->dbAdapter->query('UPDATE `ergebnis` SET `Alter`=TIMESTAMPDIFF(YEAR,(select Geburtstag from athlet where id = ?),(select Datum from event where id = ?)) WHERE `Eventid` = ? AND `Athletid` = ?', array($ergebnis->getAthletid(), $ergebnis->getEventid(), $ergebnis->getEventid(), $ergebnis->getAthletid()));
    
        if (!$ergebnis->getEventid() && !$ergebnis->getAthletid())  {
            $ergebnis->setId($result->getGeneratedValue());
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
    
//         print_r($ergebnis);
        return $ergebnis;
    }
    
    public function getKindergebnis($id, $kid)
    {
        $result = $this->dbAdapter->query('SELECT * FROM `kinderlauf` WHERE `Eventid` = ? and Kindid = ?', array($id,$kid));
//         $statement->execute()->current();
        $test = $result->count();
        if (!$test) {
            return null;
        }
    
//         $hydrator = new ClassMethods();
//         $ergebnis = new ErgebnisEntity();
//         $hydrator->hydrate($test, $ergebnis);
    
        return $test;
    }
    
    public function checkAnzahl($eventid)
    {
        $action = $this->dbAdapter->query('SELECT Count(*) AS anzahl FROM `ergebnis` WHERE `Eventid` = ?', array($eventid));
        $test = $action->toArray();
        $anzahl = $test[0]['anzahl'];
//         echo "Anzahl";
//         echo $anzahl;
        
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
//         echo "Guthaben";
//         echo $konto;
    
        return $konto;
    
    }
    
   
    public function updatePlatzierung($erg)
    {
        $i = 1;
        echo "<br>";
        
        foreach ($erg as $ergebnis)
        {
//             echo "Iterator";
//             echo $i;
//             echo"<br>Event";
//             echo $ergebnis->getEventid();
//             echo"<br>Athlet";
//             echo $ergebnis->getAthletid();
//             echo"<br>";
            $action = $this->dbAdapter->query('UPDATE `ergebnis` SET `Gesamtplatzierung`= ?  WHERE `Eventid`=? AND `Athletid`=?', array($i, $ergebnis->getEventid(), $ergebnis->getAthletid()));
//             echo $i;
            
            $i++;
        }
    }
    
    public function deleteErgebnis($id, $athletid)
    {
        $delete = $this->sql->delete();
        $delete->where(array('eventid' => $id,'athletid' => $athletid ));;
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function lastschrift($athlet, $event)
    {
        //Durch das Objekt Event wird der Veranstalter geladen
        $action = $this->dbAdapter->query('SELECT a.id AS id FROM `veranstalter`a, `veranstaltung`b, `event`c WHERE a.id = b.veranstalterid AND b.id = c.veranstaltungsid  AND c.id = ?', array($event->getId()));
        $test = $action->toArray();
        $vid = $test[0]['id'];
        
        //Holen des Veranstalter-Objekts
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($vid);
        
        //Buchung Athlet
        $action2 = $this->dbAdapter->query('INSERT INTO `athlet_buchung`(`IBAN`, `BIC`, `Datum`, `Athletid`, `Wert`) VALUES (?,?,NOW(),?,-?)', array($athlet->IBAN, $athlet->BIC, $athlet->id, $event->getAnmeldegebuehr()));

        //Buchung Veranstalter
        $action4 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $event->getAnmeldegebuehr()));
        
        
    }
    
    public function guthaben($athlet, $event)
    {
        //Durch das Objekt Event wird der Veranstalter geladen
        $action = $this->dbAdapter->query('SELECT a.id AS id FROM `veranstalter`a, `veranstaltung`b, `event`c WHERE a.id = b.veranstalterid AND b.id = c.veranstaltungsid  AND c.id = ?', array($event->getId()));
        $test = $action->toArray();
        $vid = $test[0]['id'];
    
        //Holen des Veranstalter-Objekts
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($vid);
    
        //Aktualisieren des Guthabens
        $action3 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` - ?) WHERE `Athletid` = ?', array($event->getAnmeldegebuehr(), $athlet->id));
    
        //Überprüfen, ob Multiplikator in Multiplikator Tabelle ist mit Freigegeben "1"
        $action3 = $this->dbAdapter->query('SELECT Wert AS multiplikatorwert FROM `multiplikator` WHERE `Eventid` = ? AND `Freigegeben` = 1', array($event->getId()));
        $test2 = $action3->toArray();
        $multiplikatorwert = $test2[0]['multiplikatorwert'];
        
        // Falls kein Eintrag für das gewählte Event mit dem Status Freigegeben = "1" in der multiplikator-Tabelle
        // vorhanden ist, wird eine normale CB-Buchung durchgeführt
        if($multiplikatorwert == NULL)
        {
            // ganz normale Cash-Back-Buchung:
            // Athlet erhält pro € Anmeldegebühr einen Cent auf sein Konto vom Betreiber überwiesen
            // Zuerst den Bonus-Cent-Betrag auf das Athletenkonto buchen(1 Cent pro € Anmeldegebühr)
            $bonusbetrag = round((($event->getAnmeldegebuehr())/100), 2);
            $action4 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` + ?) WHERE `Athletid` = ?', array($bonusbetrag, $athlet->id));
        
            // Gerade gebuchten Cash-Back-Betrag vom Betreiberkonto abziehen
            $action5 = $this->dbAdapter->query('INSERT INTO `betreiberkonto` (`Wert`, `Datum`) VALUES (?, NOW())', array(($bonusbetrag * (-1))));
        }
        // Falls ein Eintrag vorhanden ist, wird die zweite Art der CB-Buchung durchgeführt:
        else
        {
            // Zuerst werden die Beträge errechnet, die auf die jeweiligen Konten gebucht werden
            // Der Athlet bekommt die Bonus-Cents in diesem Fall vom Veranstalter überwiesen
            $bonusbetragathletveranstalter = ($multiplikatorwert * round((($event->getAnmeldegebuehr())/100), 2));
            
            // Der Betreiber bekommt das Doppelte des Multiplikator-Werts vom Veranstalter, für die CB-Aktion
            $bonusbetragbetreiber = ( 2 * ($multiplikatorwert * round((($event->getAnmeldegebuehr())/100), 2)));
            
            // Zunächst den errechneten Bonus-Cent-Betrag auf das Athletenkonto buchen/gutschreiben
            $action4 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` + ?) WHERE `Athletid` = ?', array($bonusbetragathletveranstalter, $athlet->id));
            
            // Der Veranstalter bezahlt den Bonus-Cent-Betrag, den der Athlet erhält
            $action5 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), ($bonusbetragathletveranstalter * (-1))));
            
            // Als letztes bekommt der Betreiber für die CB-Aktion 2*den Bonus-Cent-Betrag vom Veranstalter
            $action6 = $this->dbAdapter->query('INSERT INTO `betreiberkonto` (`Wert`, `Datum`) VALUES (?, NOW())', array($bonusbetragbetreiber));
            
            // Der Veranstalter bezahlt den Betrag an den Betreiber
            $action7 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), ($bonusbetragbetreiber * (-1))));
        }
        
        //Buchung Veranstalter
        $action8 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $event->getAnmeldegebuehr()));
        
// Michael Aringer 24.01.2015 EINGEFÜGT ENDE
    
        //Buchung Veranstalter
        $action4 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $event->getAnmeldegebuehr()));
    
    
    }
    
    public function back($athlet, $event)
    {
        print_r($event);
        //Durch das Objekt Event wird der Veranstalter geladen
        $action = $this->dbAdapter->query('SELECT a.id AS id FROM `veranstalter`a, `veranstaltung`b, `event`c WHERE a.id = b.veranstalterid AND b.id = c.veranstaltungsid  AND c.id = ?', array($event->getId()));
        $test = $action->toArray();
        $vid = $test[0]['id'];
    
        //Holen des Veranstalter-Objekts
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($vid);
    
        //Aktualisieren des Guthabens
        $action3 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` + ?) WHERE `Athletid` = ?', array($event->getAnmeldegebuehr(), $athlet->id));
    
          
        //Überprüfen, ob es zum dem Event einen Eintrag in der Multiplikator Tabelle gibt mit Freigegeben "1"
        $action3 = $this->dbAdapter->query('SELECT Wert AS multiplikatorwert FROM `multiplikator` WHERE `Eventid` = ? AND `Freigegeben` = 1', array($event->getId()));
        $test2 = $action3->toArray();
        $multiplikatorwert = $test2[0]['multiplikatorwert'];
        
        // Falls kein Eintrag für das gewählte Event mit dem Status Freigegeben = "1" in der multiplikator-Tabelle
        // vorhanden ist, werden die CB Buchungen wieder rückgebucht(Analog wie bei guthaben()-Fkt. oben)
        if($multiplikatorwert == NULL)
        {
            // Rückbuchungen bei normaler Cash-Back-Buchung:
            // Athlet erhält pro € Anmeldegebühr einen Cent auf sein Konto vom Betreiber überwiesen
            // Zuerst den Bonus-Cent-Betrag wieder vom Athletenkonto abziehen(1 Cent pro € Anmeldegebühr)
            $bonusbetrag = round((($event->getAnmeldegebuehr())/100), 2);
            $action4 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` - ?) WHERE `Athletid` = ?', array($bonusbetrag, $athlet->id));
        
            // Den Cash-Back-Betrag wieder auf das Betreiberkonto buchen
            $action5 = $this->dbAdapter->query('INSERT INTO `betreiberkonto` (`Wert`, `Datum`) VALUES (?, NOW())', array(($bonusbetrag)));
        }
        // Falls ein Eintrag in Tabelle "multiplikator" vorhanden ist, werden die CB-Buchungen auf die andere Art zurückgebucht:
        else
        {
            // Zuerst werden die Beträge errechnet, die auf die jeweiligen Konten gebucht wurden
            // Der Athlet bekam die Bonus-Cents vom Veranstalter überwiesen
            $bonusbetragathletveranstalter = ($multiplikatorwert * round((($event->getAnmeldegebuehr())/100), 2));
        
            // Der Betreiber bekam das Doppelte des Multiplikator-Werts vom Veranstalter, für die CB-Aktion
            $bonusbetragbetreiber = ( 2 * ($multiplikatorwert * round((($event->getAnmeldegebuehr())/100), 2)));
        
            // Zunächst den errechneten Bonus-Cent-Betrag vom Athletenkonto wieder abziehen
            $action4 = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand`=(`Kontostand` - ?) WHERE `Athletid` = ?', array($bonusbetragathletveranstalter, $athlet->id));
        
            // Der Veranstalter bekommt den bereits bezahlten Bonus-Cent-Betrag wieder zurücküberwiesen
            $action5 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $bonusbetragathletveranstalter));
        
            // Vom Betreiberkonto wird 2* der Bonus-Cent-Betrag wieder abgezogen
            $action6 = $this->dbAdapter->query('INSERT INTO `betreiberkonto` (`Wert`, `Datum`) VALUES (?, NOW())', array(($bonusbetragbetreiber * (-1))));
        
            // Der Veranstalter bekommt den an den Betreiber überwiesenen Betrag wieder zurücküberwiesen
            $action7 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $bonusbetragbetreiber));
        }
        // Michael Aringer 24.01.2015 EINGEFÜGT ENDE
        //Buchung Veranstalter
        $action4 = $this->dbAdapter->query('INSERT INTO `veranstalter_buchung`(`Veranstalterid`,`IBAN`, `BIC`, `Wert`, `Datum`) VALUES (?,?,?,-?,NOW())', array($veranstalter->getId(), $veranstalter->getIban(), $veranstalter->getBic(), $event->getAnmeldegebuehr()));
    
    
    }
    
    public function kind($kind, $event)
    {
//         echo "Hier";
//         echo $event;
        //Buchung Veranstalter
        $action4 = $this->dbAdapter->query('INSERT INTO kinderlauf (Eventid, Kindid, Zeit, Platzierung) VALUES (?,?, 9999999, 0)', array($event, $kind));
        
    
    }
    
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
    
}