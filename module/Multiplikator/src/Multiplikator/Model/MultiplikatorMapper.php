<?php
namespace Multiplikator\Model;

use Zend\Db\Adapter\Adapter;
use Multiplikator\Model\MultiplikatorEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class MultiplikatorMapper
{
    protected $tableName = 'multiplikator';
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

        $entityPrototype = new MultiplikatorEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function saveMultiplikator(MultiplikatorEntity $multi)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($multi);
    
        if ($multi->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $multi->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$multi->getId()) {
            $multi->setId($result->getGeneratedValue());
        }
        return $result;
    
    
    }
    
    //noch nicht getestet, bzw noch nicht benštigt
    public function getMultiplikator($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $multi = new MultiplikatorEntity();
        $hydrator->hydrate($result, $ergebnis);
    
        print_r($multi);
        return $multi;
    }
    
    //
    public function getMultiplikatorEvent($eventid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $eventid ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        if (!$results) {
            return null;
        }
    
        $entityPrototype = new MultiplikatorEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;

    }
    
    public function ueberschneidung($event, $anfang, $ende)
    {
        $edatum = $event->getDatum();
        if($anfang<$ende && $edatum >=$ende ){
            return true;
        } else {
            return false;
        }
    
    }
    
    
    
}