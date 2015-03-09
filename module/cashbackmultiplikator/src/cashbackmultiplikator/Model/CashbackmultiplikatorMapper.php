<?php
namespace Cashbackmultiplikator\Model;

use Zend\Db\Adapter\Adapter;
use Cashbackmultiplikator\Model\CashbackmultiplikatorEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class CashbackmultiplikatorMapper
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
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new CashbackmultiplikatorEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    // Ändert den Status(Tabellenfeld: Freigegeben) eines Multiplikators; entweder auf 1 oder 0 setzen
    public function statusaendernCashbackmultiplikator(CashbackmultiplikatorEntity $cashbackmultiplikator)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($cashbackmultiplikator);
    
        // Update Befehl
        $id = $cashbackmultiplikator->getId();
        $freigegeben = $cashbackmultiplikator->getFreigegeben();
    
        // DB Eintrag mit Update Query
        $action = $this->dbAdapter->query('UPDATE `multiplikator` SET Freigegeben = ? WHERE id = ?', array($freigegeben, $id));
    
        return true;
    }
    
    public function getCashbackmultiplikator($Id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $Id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $cashbackmultiplikator = new CashbackmultiplikatorEntity();
        $hydrator->hydrate($result, $cashbackmultiplikator);
    
        return $cashbackmultiplikator;
    }
    
    public function deleteCashbackmultiplikator($cashbackmultiplikator)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($cashbackmultiplikator);
    
        $id = $cashbackmultiplikator->getId();
    
        // Update Befehl in der Event-Tabelle
        $action = $this->dbAdapter->query('DELETE FROM `multiplikator` WHERE id = ?', array($id));
        return true;
    }
}