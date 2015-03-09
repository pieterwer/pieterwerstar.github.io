<?php
namespace Strecke\Model;

use Zend\Db\Adapter\Adapter;
use Strecke\Model\StreckeEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class StreckeMapper
{
    protected $tableName = 'streckenzuordnung';
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

        $entityPrototype = new StreckeEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveStrecke(StreckeEntity $strecke)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($strecke);
        echo "In Funktion";
        if ($strecke->getId()) {
            // update action
            echo "Update";
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $strecke->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            echo "Insert";
            
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$strecke->getId())  {
            $strecke->setId($result->getGeneratedValue());
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
    
    public function getStrecke($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $strecke = new StreckeEntity();
        $hydrator->hydrate($result, $strecke);
    
        return $strecke;
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
    
}