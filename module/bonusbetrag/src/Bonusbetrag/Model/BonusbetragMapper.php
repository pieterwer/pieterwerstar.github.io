<?php
namespace Bonusbetrag\Model;

use Zend\Db\Adapter\Adapter;
use Bonusbetrag\Model\BonusbetragEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class BonusbetragMapper
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
    
        $entityPrototype = new BonusbetragEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    // Ändert den Status(Tabellenfeld: Freigegeben) eines Multiplikators; entweder auf 1 oder 0 setzen
    public function wertaendernBonusbetrag(BonusbetragEntity $bonusbetrag)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($bonusbetrag);
    
        // Update Befehl
        $id = $bonusbetrag->getId();
        $wert = $bonusbetrag->getWert();
    
        // DB Eintrag mit Update Query
        $action = $this->dbAdapter->query('UPDATE `multiplikator` SET Wert = ? WHERE id = ?', array($wert, $id));
    
        return true;
    }
    
    public function getBonusbetrag($Id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $Id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $bonusbetrag = new BonusbetragEntity();
        $hydrator->hydrate($result, $bonusbetrag);
    
        return $bonusbetrag;
    }
}