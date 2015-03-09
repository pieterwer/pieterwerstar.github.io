<?php
namespace Lizenz\Model;

use Zend\Db\Adapter\Adapter;
use Lizenz\Model\LizenzEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class LizenzMapper
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
    
    // Speichert "1" für eine Lizenz in der Event Tabelle ab
    public function saveLizenz(LizenzEntity $liz)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($liz);
        //var_dump($data);

        $eventid = $liz->getEventId();
        
        // Update Befehl in der Event-Tabelle
        $action = $this->dbAdapter->query('UPDATE `event` SET Lizenz = 1 WHERE id = ?', array($eventid));
        return true;
    }
    

    public function getLizenzMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LizenzMapper');
    }
}