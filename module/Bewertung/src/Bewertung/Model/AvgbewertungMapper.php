<?php
namespace Bewertung\Model;

use Zend\Db\Adapter\Adapter;
use Bewertung\Model\AvgbewertungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class AvgbewertungMapper
{
    protected $tableName = 'avgbewertung';
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

        $entityPrototype = new AvgbewertungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function Durchschnitt($evid)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $evid));
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new AvgbewertungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
   
    
}