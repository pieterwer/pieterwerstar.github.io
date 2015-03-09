<?php
namespace Starmina\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Starmina\Model\EventEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;

class EventMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'event';
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

        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        $resultset->buffer();
        foreach($resultset as $result){
            $sportart = $this->getEventsportartMapper()->getSportart($result->getId());
            $result->setSportart($sportart);
        }
        return $resultset;
    }
    
    public function searchAll($name = null)
    {
        $dbAdapter = $this->dbAdapter;
//                     $sql       = 'SELECT * FROM logindaten WHERE Email = ?';
        $eventname = '%'. $name .'%';
//         print_r($eventname);
        $params = array($eventname);
        $statement = $dbAdapter->query('SELECT * FROM event WHERE Name like ?');
//         $statement = $dbAdapter->query('SELECT * FROM event WHERE `id` in (SELECT eventid FROM `event_eventkategorie_zuordnung` where `Eventkategorieid` in (2,5) )');
        $results    = $statement->execute($params);
    
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        $resultset->buffer();
        foreach($resultset as $result){
            $sportart = $this->getEventsportartMapper()->getSportart($result->getId());
            $result->setSportart($sportart);
        }
        return $resultset;
    }
    
    public function searchAllerweitert($where = null)
    {
        $dbAdapter = $this->dbAdapter;
        $sql       = 'SELECT * FROM event';
        if ($where){
            $sql .= ' WHERE ' . $where;
        }
//         $eventname = '%'. $name .'%';
        //         print_r($eventname);
//         $params = array($eventname);
//         $statement = $dbAdapter->query('SELECT * FROM event WHERE Name like ?');
        //         $statement = $dbAdapter->query('SELECT * FROM event WHERE `id` in (SELECT eventid FROM `event_eventkategorie_zuordnung` where `Eventkategorieid` in (2,5) )');
        $statement = $dbAdapter->query($sql);
        $results    = $statement->execute();
    
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        $resultset->buffer();
        foreach($resultset as $result){
            $sportart = $this->getEventsportartMapper()->getSportart($result->getId());
            $result->setSportart($sportart);
        }
        return $resultset;
    }
    
    public function searchPlz($plz = null)
    {
        $dbAdapter = $this->dbAdapter;
        $statement = $dbAdapter->query('SELECT * FROM `event` WHERE `Postleitzahl` in ('.$plz.') ');
        $results    = $statement->execute();
    
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        $resultset->buffer();
        foreach($resultset as $result){
            $sportart = $this->getEventsportartMapper()->getSportart($result->getId());
            $result->setSportart($sportart);
        }
        return $resultset;
    }
    
    public function Eventver($verid)
    {
        $select = $this->sql->select();
        $select->where(array('veranstaltungsid' => $verid));
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function saveEvent(EventEntity $event)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($event);
        unset($data['sportart'],$data['kategorien']);
        
    
        if ($event->getId()) {
            // update action
            $action = $this->sql->update();
            $zuordnung = $this->sql;
            $action->set($data);
            $action->where(array('id' => $event->getId()));
            
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$event->getId()) {
            $event->setId($result->getGeneratedValue());
            //$zuodnung = $this->sql->setTable('event_sportart_zuordnung')
             //                       ->insert(array($event->getId(),$sportartid));
        }
//         $sportart = $this->getEventsportartMapper()->saveSportart($event->getId());
        return $result;
    
    }
    
    public function getEvent($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $event = new EventEntity();
        $hydrator->hydrate($result, $event);
        $sportart = $this->getEventsportartMapper()->getSportart($event->getId());
        $kategorien = $this->getEventkategorieMapper()->getKategorien($event->getId());
        $event->setSportart($sportart);
        $event->setKategorien($kategorien);
    
        return $event;
    }
    
    public function deleteEvent($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function deleteEventConstraints($event)
    {
        $action = $this->dbAdapter->query('DELETE FROM `event_eventkategorie_zuordnung` WHERE `Eventid`=?', array($event->getId()));
        $action2 = $this->dbAdapter->query('DELETE FROM `event_sportart_zuordnung` WHERE `Eventid`=?', array($event->getId()));
        $action3 = $this->dbAdapter->query('DELETE FROM `streckenzuordnung` WHERE `Eventid`=?', array($event->getId()));
        return $result;
    }
    
    // getVorlageid kann eigentlich gelšscht werden
    public function getVorlageid($eventid)
    {
        echo "Funzt";
        $select = $this->sql->select()->where(array(
            'Vorgaengerid' => $eventid
        ));
        //$select->order(array('id DESC', 'id DESC'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        if ($results->getAffectedRows() != NULL) {
            $max = array();
            foreach ($results as $result) {
                $max[] = $this->getEvent($result['id']);
            }
        } else {
            $max = array(
                new EventEntity()
            );
        }
        foreach ($max as $m) {
           echo $m->getId();
        }
        
        return $m->getId();
    }
    
    public function getNachfolger($eventid)
    {
        
        //$eventid = Eventid des VorgŠngers
        $select = $this->sql->select()->where(array(
            'Vorgaengerid' => $eventid
        ));
        //$select->order(array('id DESC', 'id DESC'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        if ($results->getAffectedRows() != NULL) {
            
            $text = "wurde uebernommen";
            
        } else {

            $text = "wurde nicht uebernommen";
            
        }
        return $text;
    }
    
    public function getAktuell()
    {

        
        //Test
        $action = $this->dbAdapter->query('SELECT * FROM `event` WHERE `Datum` >= CURDATE()');
        $result = $action->execute();
        echo"<br>";

        
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($result);
        $resultset->buffer();
        foreach($resultset as $x){
            $sportart = $this->getEventsportartMapper()->getSportart($x->getId());
            $x->setSportart($sportart);
        }
        return $resultset;
        
        /*
        $entityPrototype = new EventEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
        */
    }
    
    public function getEventsportartMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventsportartMapper');
    }
    
    public function getEventkategorieMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventkategorieMapper');
    }
    
    
}