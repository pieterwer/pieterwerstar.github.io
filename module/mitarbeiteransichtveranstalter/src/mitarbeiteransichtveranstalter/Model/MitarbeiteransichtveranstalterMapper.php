<?php
namespace Mitarbeiteransichtveranstalter\Model;

use Zend\Db\Adapter\Adapter;
use Mitarbeiteransichtveranstalter\Model\MitarbeiteransichtveranstalterEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\Pdo;


class MitarbeiteransichtveranstalterMapper
{
    protected $tableName = 'veranstalter';
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

        $entityPrototype = new MitarbeiteransichtveranstalterEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function searchVeranstalter($id,$email)
    {
        if($id!=NULL & $email!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
            $select->where(array('Email' => $email));
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtveranstalterEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($id!=NULL & $email==NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtveranstalterEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($id==NULL & $email!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('Email' => $email));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtveranstalterEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
    }
}