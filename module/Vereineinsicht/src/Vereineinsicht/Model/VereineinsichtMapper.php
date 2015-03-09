<?php
namespace Vereineinsicht\Model;

use Zend\Db\Adapter\Adapter;
use Vereineinsicht\Model\VereineinsichtEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class VereineinsichtMapper
{
    protected $tableName = 'verein';
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

        $entityPrototype = new VereineinsichtEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function Vereinanlegen($id,$name,$adminemail,$iban,$bic,$email,$strasse,$hausnummer,$plz,$ort,$status,$bankkontoinhaber,$vereinsvertreter,$passwort){
    
        $action2 = $this->dbAdapter->query('INSERT INTO `logindaten` VALUES (?,?,?)', array($adminemail,$passwort,"VE"));
        
        
        $action1 = $this->dbAdapter->query('INSERT INTO `verein` VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', array($id,$name,$adminemail,$iban,$bic,$email,$strasse,$hausnummer,$plz,$ort,$status,$bankkontoinhaber,$vereinsvertreter));

    }
    
    public function updateVerein($id,$name,$adminemail,$iban,$bic,$email,$strasse,$hausnummer,$plz,$ort,$status,$bankkontoinhaber,$vereinsvertreter){
    
        
   
        $action1 = $this->dbAdapter->query('UPDATE `verein` SET Name=?,Adminemail=?,IBAN=?,BIC=?,Email=?,Strasse=?,Hausnummer=?,Postleitzahl=?,Ort=?,Status=?,Bankkontoinhaber=?,Vereinsvertreter=? WHERE id=?', array($name,$adminemail,$iban,$bic,$email,$strasse,$hausnummer,$plz,$ort,$status,$bankkontoinhaber,$vereinsvertreter,$id));
    
    }
    
    public function deleteVerein($id)
    {
        $action = $this->dbAdapter->query('DELETE FROM `verein` WHERE id=?', array($id));
        
    }
    
    public function getVerein($id)
    
    
    {$select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $verein = new VereineinsichtEntity();
        $hydrator->hydrate($result, $verein);
    
        return $verein;
    }
    
    
    public function checkEmailVerein($Email)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `betreiber` WHERE Email=?',array($Email));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    public function checkEmailAdmin($Adminemail)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `logindaten` WHERE Email=?',array($Adminemail));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    public function checkID($id)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `verein` WHERE id=?',array($id));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    
}