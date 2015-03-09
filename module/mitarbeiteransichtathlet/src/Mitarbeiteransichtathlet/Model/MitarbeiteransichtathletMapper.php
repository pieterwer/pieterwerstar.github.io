<?php
namespace Mitarbeiteransichtathlet\Model;

use Zend\Db\Adapter\Adapter;
use Mitarbeiteransichtathlet\Model\MitarbeiteransichtathletEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\Pdo;


class MitarbeiteransichtathletMapper
{
    protected $tableName = 'athlet';
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

        $entityPrototype = new MitarbeiteransichtathletEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function searchAthlet($email,$name)
    {
        if($email!=NULL & $name!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('email' => $email));
            $select->where(array('Name' => $name));
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtathletEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($email!=NULL & $name==NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('email' => $email));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtathletEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($email==NULL & $name!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('name' => $name));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new MitarbeiteransichtathletEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
    }
}