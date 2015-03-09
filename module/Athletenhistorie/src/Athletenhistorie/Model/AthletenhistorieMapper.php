<?php
namespace Athletenhistorie\Model;

use Zend\Db\Adapter\Adapter;
use Athletenhistorie\Model\AthletenhistorieEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class AthletenhistorieMapper
{
    protected $tableName = 'ergebnis';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll($id)
    {
        $select = $this->sql->select();
        $select->where(array('Athletid' => $id));
        
        //$select->order(array('completed ASC', 'created ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new AthletenhistorieEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function getname($athletid)
    {   // IBAN aus der DB holen
    
    
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` where id = ?', array($athletid));
    //ausführen des statements
    $resultstest=$action2->toarray();
    //iterator auf den ersten datensatz platzieren (ist automatisch ein array)
    
    //ausgeben der id aus dem datensatz
    return $resultstest[0]['Name'];
    
    
    }
    
    public function geteventname($id)
    {   // IBAN aus der DB holen
    
    
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT Name FROM `event` JOIN `ergebnis` on event.id=ergebnis.Eventid where ergebnis.Athletid = ?', array($id));
            
    $resultstest=$action2->toarray();
    return $resultstest;
    
    
    }
    
    public function getvorname($athletid)
    {   // IBAN aus der DB holen
    
    
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` where id = ?', array($athletid));
    //ausführen des statements
    $resultstest=$action2->toarray();
    //iterator auf den ersten datensatz platzieren (ist automatisch ein array)
    
    //ausgeben der id aus dem datensatz
    return $resultstest[0]['Vorname'];
    
    
    }

}