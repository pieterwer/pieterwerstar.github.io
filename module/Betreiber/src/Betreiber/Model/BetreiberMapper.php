<?php
namespace Betreiber\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Betreiber\Model\BetreiberEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class BetreiberMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'betreiber';
    protected $dbAdapter;
    protected $sql;
    protected $service_manager;

    
//Getter und Setter
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->service_manager;
    }

 
//Konstruktor
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    
//Mitarbeiter-/Adminliste holen
    public function fetchAll()
    {
       // $select = $this->sql->select();
       // $select->order('Email');

        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from($this->tableName)
        ->join('logindaten', 'betreiber.Email = logindaten.Email');
        
        
        
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new BetreiberEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    

    public function searchBetreiber($email2,$nachname2)
    {
    if($email2!=NULL & $nachname2!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('email' => $email2));
            $select->where(array('Name' => $nachname2));
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new BetreiberEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($email2!=NULL & $nachname2==NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('email' => $email2));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new BetreiberEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
        if($email2==NULL & $nachname2!=NULL){
            $select = $this->sql->select();
    
            // Where Klausel wird gesetzt
            $select->where(array('Name' => $nachname2));
             
    
    
            //$select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new BetreiberEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    }

    
//Mitarbeiter/Admin hinzufügen oder bearbeiten
    public function saveBetreiber(BetreiberEntity $betreiber)
    {
        
        
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($betreiber);
        
        if ($betreiber->getId()) {
            // update action
            $action = $this->sql->update();
            $zuordnung = $this->sql;
            $action->set($data);
            $action->where(array('id' => $betreiber->getId()));
            
        } else {
            // insert action
            $action = $this->dbAdapter->query('INSERT INTO `logindaten` VALUES (?,?)', array($betreiber->getEmail(),$betreiber->getPasswort()));
            var_dump($betreiber);
            
            
            $action = $this->dbAdapter->query('INSERT INTO `betreiber` VALUES (?,?,?,?)',array(5,$betreiber->getEmail(),$betreiber->getVorname(),$betreiber->getNachname()));
             
            
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$betreiber->getId()) {
            $betreiber->setId($result->getGeneratedValue()); 
        }
        return $result; 
    }
    
    
    
    public function getPasswort($email){
        
        $action = $this->dbAdapter->query('SELECT * FROM `logindaten` WHERE Email=?',array($email));
        
        $resultstest=$action->toarray();
        
        return $resultstest[0]['Passwort'];
    }
    
   
    
    
    
    public function Betreiberanlegen($id,$email,$name,$vorname,$passwort,$rolle){
        
        
        $action = $this->dbAdapter->query('INSERT INTO `logindaten` VALUES (?,?,?)', array($email,$passwort,$rolle));
        
       
        $action1 = $this->dbAdapter->query('INSERT INTO `betreiber` VALUES (?,?,?,?)', array($id,$email,$vorname,$name));
        
        
        
    }
    
    
    
    public function updatebetreiber($id,$email,$name,$vorname,$passwort,$rolle){
    

    
        $action1 = $this->dbAdapter->query('UPDATE `betreiber` SET id=?,Email=?,Vorname=?,Name=?  WHERE Email=?', array($id,$email,$vorname,$name,$email));
    
        $action = $this->dbAdapter->query('UPDATE  `logindaten` SET Email=?,Passwort=?,Rolle=? WHERE Email=?', array($email,$passwort,$rolle,$email));
    }
    

//Mitarbeiter/Admin anzeigen  
    public function getBetreiber($email)
    {    
        
         $select = $this->sql->select();
        $select->where(array('Email' => $email));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $betreiber = new BetreiberEntity();
        $hydrator->hydrate($result, $betreiber);
    
        return $betreiber;
    }

    public function checkEmailBetreiber($Email)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `betreiber` WHERE Email=?',array($Email));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    public function checkEmailLogindaten($Email)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `logindaten` WHERE Email=?',array($Email));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    
    
    }
    public function getRolle()
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT Rolle FROM `logindaten`');
    
    $resultstest=$action2->toarray();
    
    return $action2;
    }
    
    public function checkID($id)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `betreiber` WHERE id=?',array($id));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    
    
   
    
    
    
    
//Mitarbeiter/Admin löschen
    public function deleteBetreiber($email)
    {
        $action = $this->dbAdapter->query('DELETE FROM `betreiber` WHERE Email=?', array($email));
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE Email=?', array($email));
    }
  
}