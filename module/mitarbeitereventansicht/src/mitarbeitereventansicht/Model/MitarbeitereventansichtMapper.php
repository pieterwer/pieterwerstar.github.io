<?php
namespace Mitarbeitereventansicht\Model;

use Zend\Db\Adapter\Adapter;
use Mitarbeitereventansicht\Model\MitarbeitereventansichtEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\Pdo;


class MitarbeitereventansichtMapper
{
    protected $tableName = 'event';
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
        $select->order('id');

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new MitarbeitereventansichtEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function searchEvent($id,$name)
    {
        if($id!=NULL & $name!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
            $select->where(array('Name' => $name));
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeitereventansichtEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($id!=NULL & $name==NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeitereventansichtEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($id==NULL & $name!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('Name' => $name));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeitereventansichtEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
    }
    
}