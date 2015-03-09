<?php
namespace Veranstalterverifizieren\Model;

use Zend\Db\Adapter\Adapter;
use Veranstalterverifizieren\Model\VeranstalterverifizierenEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class VeranstalterverifizierenMapper
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
    
    // Speichert "1" für eine Lizenz in der Event Tabelle ab
    public function speichernVeranstalter(VeranstalterverifizierenEntity $veranstalterverifizieren)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($veranstalterverifizieren);
        //var_dump($data);

        $veranstalterid = $veranstalterverifizieren->getVeranstalterId();
        
        // Update Befehl in der Event-Tabelle
        $action = $this->dbAdapter->query('UPDATE `veranstalter` SET Verifiziert = 1 WHERE id=?', array($veranstalterid));
        return true;
    }
    

    public function getVeranstalterverifizierenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterverifizierenMapper');
    }
}