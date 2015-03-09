<?php
namespace Starmina\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Starmina\Model\EventkategorieEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class EventkategorieMapper implements ServiceLocatorAwareInterface
{

    protected $tableName = 'event_eventkategorie_zuordnung';

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

    public function fetchAllKategorien($eventid)
    {
        $select = $this->sql->select()->where(array(
            'eventid' => $eventid
        ));
        // $select->order(array('completed ASC', 'created ASC'));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        $entityPrototype = new KategorieEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    // ABspeichern der Zuordnung von event und sportart
    public function saveEventzu($eventid, $kategorien)
    {
        // $hydrator = new ClassMethods();
        // $data = array(
        // 'eventid' => $eventid,
        // 'eventkategorieid' => $kategorieid
        // );
        $exists = $this->sql->delete()->where(array(
            'Eventid' => $eventid
        ));
        $statementexists = $this->sql->prepareStatementForSqlObject($exists);
        $resultexists = $statementexists->execute();
        
        // insert action
        $action = $this->sql->insert();
        // unset($data['id']);
        foreach ($kategorien as $kategorie) {
            $data = array(
                'eventid' => $eventid,
                'eventkategorieid' => $kategorie
            );
        $action->values($data);
        
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        }
        
        return $result;
    }

    public function getKategorienbezeichnung($eventid)
    {
        $select = $this->sql->select()->where(array(
            'eventid' => $eventid
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        if ($results->getAffectedRows() != NULL) {
            $kategorien = array();
            foreach ($results as $result) {
                $kategorien[] = $this->getKategorieMapper()->getKategorie($result['Eventkategorieid']);
            }
        } else {
            $kategorien = array(
                new KategorieEntity()
            );
        }
        return $kategorien;
    }

    public function getKategorien($eventid)
    {
        // $select = $this->sql->select()->where(array('eventid'=>$eventid));
        // //$select->order(array('completed ASC', 'created ASC'));
        
        // $statement = $this->sql->prepareStatementForSqlObject($select);
        // $results = $statement->execute();
        
        // $entityPrototype = new EventkategorieEntity();
        // $hydrator = new ClassMethods();
        // $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        // $resultset->initialize($results);
        $select = $this->sql->select()->where(array(
            'eventid' => $eventid
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        // if (!$result) {
        // return null;
        // }
        // $resultset->buffer();
        if ($results != NULL) {
            // $ids = array();
            // foreach ($result as $id){
            // $ids[]= $result['Eventkategorieid'];
            // }
            
            $kategorien = array();
            foreach ($results as $result) {
                // $kategorien[new KategorieEntity()];
                $id = $result['Eventkategorieid'];
                $kategorien[] = $id;
            }
            
            // $kategorien = $ids;
        } else {
            $kategorien = array(
                new KategorieEntity()
            );
        }
        
        // $records = array();
        
        // foreach ($results as $result)
        // {
        // $records[] = $result;
        // }
        // $kategorien = $records;
        return $kategorien;
    }

    public function deleteEvent($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array(
            'eventid' => $id
        ));
        
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }

    public function getKategorieMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('KategorieMapper');
    }
}