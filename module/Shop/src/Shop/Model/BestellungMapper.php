<?php
namespace Shop\Model;

use Zend\Db\Adapter\Adapter;
use Shop\Model\BestellungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class BestellungMapper
{
    protected $tableName = 'bestellung';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll($veranstalter)
    {
        $select = $this->sql->select();
        $select->where(array('status' => 0, 'veranstalterid' =>$veranstalter));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new BestellungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function fetchBestellungen($veranstalter)
    {
        $select = $this->sql->select();
        $select->where(array('status' => 1, 'veranstalterid' =>$veranstalter));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new BestellungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function fetchBetreiber()
    {
        $select = $this->sql->select();
        $select->where(array('status' => 1));
        $select->order(array('veranstalterid ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new BestellungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function checkEintrag($id, $status, $menge, $veranstalter)
    {
        $action = $this->dbAdapter->query('SELECT `Artikelid`, `Status` FROM `bestellung` WHERE `Artikelid` = ? AND `Status` = ?', array($id, $status));
        $test = $action->toArray();
//         echo"checkEintrag";
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            return true;
        } 
        else 
        {
            echo "Update";
            echo $menge; echo $id;echo $status;
            $action2 = $this->dbAdapter->query('UPDATE `bestellung` SET `Menge`= (`Menge`+?) WHERE `Artikelid`= ? AND`Status`=? AND `Veranstalterid` = ?', array($menge,$id, $status, $veranstalter));
            return false;
        }  
    
    }
    
    public function bestellen($veranstalter)
    {
        $action = $this->dbAdapter->query('UPDATE `bestellung` SET `Status`= 1,`Datum`= NOW() WHERE `Veranstalterid` = ? AND `Status` = 0', array($veranstalter));
    
    }
    
}