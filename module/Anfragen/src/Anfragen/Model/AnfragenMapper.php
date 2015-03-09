<?php
namespace Anfragen\Model;

use Zend\Db\Adapter\Adapter;
use Anfragen\Model\AnfragenEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class AnfragenMapper
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
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new AnfragenEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    // Speichert "1" für eine Lizenz in der Event Tabelle ab
    public function saveLizenz(AnfragenEntity $anfrage)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($anfrage);
        var_dump($data);

        $lizenz =$anfrage->getLizenz();
        $eventid = $anfrage->getEventId();

        echo '<br>';
        echo '<br>';
        print_r($anfrage);
        
        // Update Befehl in der Event-Tabelle
        $action = $this->dbAdapter->query('UPDATE `event` SET Lizenz=? WHERE id=?', array($lizenz, $eventid));
        return true;
    }
    

    public function getAnfragenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AnfragenMapper');
    }
}