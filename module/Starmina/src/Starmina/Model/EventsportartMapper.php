<?php
namespace Starmina\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Starmina\Model\EventsportartEntity;
use Starmina\Model\SportartEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class EventsportartMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'event_sportart_zuordnung';
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

        $entityPrototype = new EventsportartEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    //ABspeichern der Zuordnung von event und sportart
    public function saveEventzu($eventid, $sportartid)
    {
        $hydrator = new ClassMethods();
        $data = array('eventid' => $eventid,'sportartid' => $sportartid);
        $exists = $this->sql->select()->where(array('eventid' => $eventid));
        $statementexists = $this->sql->prepareStatementForSqlObject($exists);
        $resultexists = $statementexists->execute();
        
        if ($resultexists->getAffectedRows() > 0) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('eventid' => $eventid));
        } else {
            // insert action
            $action = $this->sql->insert();
            //unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        
        return $result;
    
    }
    
    public function getSportart($eventid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $eventid));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
//         if (!$result) {
//             return null;
//         }
        if($result['Sportartid']!=NULL){
        $sportart = $this->getSportartMapper()->getSportart($result['Sportartid']);
        }else{
            $sportart = new SportartEntity();
        }
    
        
        return $sportart;
    }
    
    public function deleteEvent($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function getSportartMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('SportartMapper');
    }
}