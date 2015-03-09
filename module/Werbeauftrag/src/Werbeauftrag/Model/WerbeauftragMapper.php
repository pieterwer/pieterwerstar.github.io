<?php
namespace Werbeauftrag\Model;

use Zend\Db\Adapter\Adapter;
use Werbeauftrag\Model\WerbeauftragEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\Pdo;


class WerbeauftragMapper
{
    protected $tableName = 'werbeauftrag';
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
        $select->order('id');

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new WerbeauftragEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function fetchAllZuordnung($id)
    {
        $action = $this->dbAdapter->query('SELECT * FROM `athleten_werbeauftraege_zuordnung` WHERE Werbeauftragid=?', array($id));
        $resultstest=$action->toarray();
        
        return $resultstest;
    }
    
    public function fetchAllZuordnungVeranstalter($id)
    {
        $action = $this->dbAdapter->query('SELECT * FROM `werbeauftraege_veranstalter_zuordnung` WHERE werbeauftragid=?', array($id));
        $resultstest=$action->toarray();
        
        return $resultstest;
    }
    
    public function checkwerbeauftragid($werbeauftragid)
    {   // Überprüft ob es den Werbeauftrag überhaupt gibt
    
        $action2 = $this->dbAdapter->query('SELECT * FROM `werbeauftrag` WHERE id=?',array($werbeauftragid));
        
        $resultstest=$action2->toarray();
        
        return $resultstest;
    }
    
    public function checkathletid($athletid)
    {   // Überprüft ob es den Werbeauftrag überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` WHERE id=?',array($athletid));
    
    $resultstest=$action2->toarray();
    
    return $resultstest[0]['id'];
    
    }
    
    public function checkveranstalterid($veranstalterid)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
                                                                    
        $action2 = $this->dbAdapter->query('SELECT * FROM `veranstalter` WHERE id=?',array($veranstalterid));
                                     
        $resultstest=$action2->toarray();
                                                 
        return $resultstest;
    }
    
    
    public function checkEintragZuordnungVeranstalter($werbeauftragid,$veranstalterid)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `werbeauftraege_veranstalter_zuordnung` WHERE werbeauftragid=? AND veranstalterid=?',array($werbeauftragid,$veranstalterid));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    
    
    public function checkEintragZuordnungAthleten($werbeauftragid,$athletid)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `athleten_werbeauftraege_zuordnung` WHERE Werbeauftragid=? AND Athletid=?',array($werbeauftragid,$athletid));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    
    public function createZuweisungWerbeauftragathlet($werbeauftragid,$athletid)
    {
        $action = $this->dbAdapter->query('INSERT INTO `athleten_werbeauftraege_zuordnung` VALUES(?,?)', array($athletid,$werbeauftragid));
       
    }
    
    public function createZuweisungWerbeauftragVeranstalter($werbeauftragid,$veranstalterid)
    {
        $action = $this->dbAdapter->query('INSERT INTO `werbeauftraege_veranstalter_zuordnung` VALUES(?,?)', array($werbeauftragid,$veranstalterid));
         
    }
    
    public function searchWerbeauftrag($id,$name)
    {
        if($id!=NULL & $name!=NULL){
            $select = $this->sql->select();

            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
            $select->where(array('Name' => $name));
            
            
            //$select->order('id');
            
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            
            $entityPrototype = new WerbeauftragEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
        if($id!=NULL & $name==NULL){
            $select = $this->sql->select();
        
            // Where Klausel wird gesetzt
            $select->where(array('id' => $id));
           
        
        
            //$select->order('id');
        
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
        
            $entityPrototype = new WerbeauftragEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
        if($id==NULL & $name!=NULL){
            $select = $this->sql->select();
        
            // Where Klausel wird gesetzt
            $select->where(array('Name' => $name));
             
        
        
            //$select->order('id');
        
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
        
            $entityPrototype = new WerbeauftragEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
    }
    
    
 public function saveWerbeauftrag(WerbeauftragEntity $werbeauftrag1)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($werbeauftrag1);
    
       //  hier fehlt noch die Überprüfung ob der Werbeauftrag bereits existiert
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        //$action = $this->dbAdapter->query('INSERT INTO `werbeauftrag`(`id`, `Name`) VALUES (?,?)', array($werbeauftrag1->getId(),$werbeauftrag1->getName(),$this->tableName));
        if (!$werbeauftrag1->getId()) {
            $werbeauftrag1->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    
    
    public function saveWerbeauftrag_Athlet($id)
    {
        
        // gekünstelte Werte ausbessern: AthletID
        $action = $this->dbAdapter->query('INSERT INTO `athleten_werbeauftraege_zuordnung` VALUES ("1",?)',array($id));
    }
    
    
    
    
    public function getmaxid()
    {
    
        $action2 = $this->dbAdapter->query('SELECT max(id) as max FROM `werbeauftrag`');
        //ausführen des statements
        $resultstest=$action2->toarray();
        //iterator auf den ersten datensatz platzieren (ist automatisch ein array)
    
        //ausgeben der id aus dem datensatz
        return $resultstest[0]['max'];
    
       

    }
    
    public function updateWerbeauftrag(WerbeauftragEntity $werbeauftrag1)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($werbeauftrag1);
    
        if ($werbeauftrag1->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $werbeauftrag1->getId()));
        
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$werbeauftrag1->getId()) {
            $werbeauftrag1->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    }
    
    public function getWerbeauftrag($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $werbeauftrag = new WerbeauftragEntity();
        $hydrator->hydrate($result, $werbeauftrag);
    
        return $werbeauftrag;
    }
    
    public function deleteWerbeauftrag($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
        
        $action = $this->dbAdapter->query('DELETE FROM athleten_werbeauftraege_zuordnung WHERE Werbeauftragid=?',array($id));
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function checkname($name)
    {
    
        //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT * FROM `werbeauftrag` where Name = ?', array($name));
        
        //ausführen des statements
        $resultstest=$action2->toarray();
    
        //ausgeben der id aus dem datensatz
        $check=$resultstest[0]["Name"];
    
        return $check;
    
    }
   
    
}