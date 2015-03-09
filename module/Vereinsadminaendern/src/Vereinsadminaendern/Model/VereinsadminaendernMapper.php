<?php
namespace Vereinsadminaendern\Model;

use Zend\Db\Adapter\Adapter;
use Vereinsadminaendern\Model\VereinsadminaendernEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

use Athletenbezahlung\Model\AthletenbezahlungEntity;
use Athletenbezahlung\Model\gruppiertBezahlungEntity;

use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Vereinsadminaendern\Controller\VereinsadminaendernController;

class VereinsadminaendernMapper
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
        $select->where(array('Status' => 0));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new VereinsadminaendernEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function searchVerein($id)
    {
        if($id!=NULL ){
            $select = $this->sql->select();
        $select->where(array('id' => array($id)));
            
    
             
    
            $select->order('id');
    
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
    
            $entityPrototype = new VereinsadminaendernEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
    
     
    
    }
    
    
    public function saveVereinsadminaendern($adminemail,$vereinid)
    {
  
        $action = $this->dbAdapter->query('UPDATE `verein` SET Adminemail=?,Status=? WHERE id=?', array($adminemail,"1",$vereinid));
    }
    
    
    public function saveLogin($adminemail, $passwort)
    {
        
        
        //Rolle gehört geändert
        $action = $this->dbAdapter->query('INSERT INTO `logindaten`(`Email`, `Passwort`, `Rolle`) VALUES (?,?,?)', array($adminemail,$passwort,'ve'));
        
    }
    
  
    
    
    public function deleteAltenAdmin(VereinsadminaendernEntity $vereinsadminaendern)
    {   
        //Email des alten Admins holen
        $id=$vereinsadminaendern->getId();
        
        //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT * FROM `verein` where id = ?', array($id));
        
        //ausführen des statements
        $resultstest=$action2->toarray();
        
        //ausgeben der id aus dem datensatz
        $alteadminemail=$resultstest[0]["Adminemail"];
        
        
        
        return $alteadminemail;
        
    }
    
    public function deleteAltenAdmin123($alteadminemail)
    {
       
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE Email=?', array($alteadminemail));
    
    }
    
    public function checkid($vereinid)
    {
        //Email des alten Admins holen

        //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT id FROM `verein` where id = ? AND Status=0', array($vereinid));
    
        //ausführen des statements
        $resultstest=$action2->toarray();
        
        
            
            return $resultstest;
       
    
    }
    

    public function checkemaillogin($adminemail)
    {
        //Email des alten Admins holen
    
        //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT Rolle FROM `logindaten` where Email = ?', array($adminemail));
    
        //ausführen des statements
        $resultstest=$action2->toarray();
      
            
            return $resultstest;
     
    
    }
    
}