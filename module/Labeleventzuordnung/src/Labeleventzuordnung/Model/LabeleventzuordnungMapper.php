<?php
namespace Labeleventzuordnung\Model;

use Zend\Db\Adapter\Adapter;
use Labeleventzuordnung\Model\LabeleventzuordnungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class LabeleventzuordnungMapper
{
    protected $tableName = 'event_label_zuordnung';
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

        $entityPrototype = new LabeleventzuordnungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    // Ändert den Status einer Label Event Zuordnung; entweder auf 1 oder 0 setzen
    public function statusaendernLabeleventzuordnung(LabeleventzuordnungEntity $labeleventzuordnung)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($labeleventzuordnung);
    
            // Update Befehl
            $eventid = $labeleventzuordnung->getEventId();
            $labelid = $labeleventzuordnung->getLabelId();
            $status = $labeleventzuordnung->getStatus();
            
            // DB Eintrag mit Update Query
            $action = $this->dbAdapter->query('UPDATE `event_label_zuordnung` SET Status = ? WHERE Eventid = ? AND Labelid = ?', array($status, $eventid, $labelid));
        
        return true;
    }
    
    public function getLabeleventzuordnung($EventId)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $EventId));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $labeleventzuordnung = new LabeleventzuordnungEntity();
        $hydrator->hydrate($result, $labeleventzuordnung);
    
        return $labeleventzuordnung;
    }
    
    public function deleteLabeleventzuordnung($labeleventzuordnung)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($labeleventzuordnung);
        
        $eventid = $labeleventzuordnung->getEventId();
        $labelid = $labeleventzuordnung->getLabelId();
        
        // Update Befehl in der Event-Tabelle
        $action = $this->dbAdapter->query('DELETE FROM `event_label_zuordnung` WHERE Eventid = ? AND Labelid = ?', array($eventid, $labelid));
        return true;
    }    
}