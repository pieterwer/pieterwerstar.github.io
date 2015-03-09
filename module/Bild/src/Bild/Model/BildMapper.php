<?php
namespace Bild\Model;

use Zend\Db\Adapter\Adapter;
use Bild\Model\BildEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class BildMapper
{
    protected $tableName = 'Bild';
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

        $entityPrototype = new BildEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveBild(BildEntity $bild)
    {
        $hydrator = new ClassMethods();
//         $data = $hydrator->extract($bild);
//         echo $bild->getLink();
//         unset($data['inputFilter']);
        $data['bildname'] = $bild->getBildname();
        $data['link'] = $bild->getLink();
    
        if ($bild->getId()) {
            // update action
            $action = $this->sql->update();
            $zuordnung = $this->sql;
            $action->set($data);
            $action->where(array('id' => $bild->getId()));
            
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$bild->getId()) {
            $bild->setId($result->getGeneratedValue());
            //$zuodnung = $this->sql->setTable('event_sportart_zuordnung')
             //                       ->insert(array($event->getId(),$sportartid));
        }
//         $sportart = $this->getEventsportartMapper()->saveSportart($event->getId());
        return $result;
    
    }
    
    public function saveLogin(BildEntity $Bild, $passwort)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($Bild);
        // Vielleicht †berprŸfung: Meldung
        if ($Bild->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $Bild->getId()));
        } else {
            // insert action
//             unset($data['id']);
//             $action->values($data);
            $action = $this->dbAdapter->query('INSERT INTO `logindaten`(`Email`, `Passwort`, `Rolle`) VALUES (?,?,?)', array($Bild->getEmail(),'Passwort',$this->tableName));
        }
//         $statement = $this->sql->prepareStatementForSqlObject($action);
//         $result = $statement->execute();
    
//         if (!$Bild->getId()) {
//             $Bild->setId($result->getGeneratedValue());
//         }
        return $result;
    
    }
    
    public function getBild($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $Bild = new BildEntity();
        $hydrator->hydrate($result, $Bild);
    
        return $Bild;
    }
    
    public function deleteBild($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function deleteLogin($Bild)
    {
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE `Email`=?', array($Bild->getEmail()));
        return $result;
    }
    
}