<?php
namespace Starmina\Model;

use Zend\Db\Adapter\Adapter;
use Starmina\Model\AthletenbezahlungEntity;
use Starmina\Model\gruppiertBezahlungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;




class AthletenbezahlungMapper
{
    protected $tableName = 'athlet_buchung';
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

        $entityPrototype = new AthletenbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function fetchAllgroup()
    {    
        
        
        // Gruppierung einfügen
        $select = $this->sql->select();
        $select->columns(array('Verwendungszweck','anzahlathleten' => new Expression('COUNT(id)'),'wertsum' => new Expression('SUM(wert)')))
        ->group('Verwendungszweck');
        
        
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new AthletenbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function fetchAllindividuell($id,$useid)
    {    
        
        // Verzweigung welche Parameter angegeben wurden
        if($id!=NULL & $useid!=NUll){
            $select = $this->sql->select();
            $select->where(array('Athletid' => $id));
            $select->where(array('Verwendungszweck' => $useid));
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            
            $entityPrototype = new AthletenbezahlungEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
        
        if($id!=NULL & $useid==NUll){
            $select = $this->sql->select();
            $select->where(array('Athletid' => $id));
            
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
        
            $entityPrototype = new AthletenbezahlungEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
        
        if($id==NULL & $useid!=NUll){
            $select = $this->sql->select();
            
            $select->where(array('Verwendungszweck' => $useid));
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
        
            $entityPrototype = new AthletenbezahlungEntity();
            $hydrator = new ClassMethods();
            $resultset = new HydratingResultSet($hydrator, $entityPrototype);
            $resultset->initialize($results);
            return $resultset;
        }
        
    }
    
    public function backtoAthlet($id,$athletid,$wert)
    {
        $hydrator = new ClassMethods();
      
        $action = $this->dbAdapter->query('DELETE FROM `athlet_buchung` WHERE Athletid=? AND id=?', array($athletid,$id));
        $action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  id=?', array($id));
       
        
        
        $action = $this->dbAdapter->query('UPDATE `athlet_guthaben_konto` SET Kontostand=Kontostand+? WHERE Athletid=?', array($wert,$athletid));
    
    }
    
    public function forwardtoVeranstalter($id,$athletid,$useID,$wert)
    {
        // TO-DO Fehlerabfragen
        
        
        
        $hydrator = new ClassMethods();
        // Statements funktionieren !!
        
        $action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  id=?', array($id));
        $action = $this->dbAdapter->query('DELETE FROM `athlet_buchung` WHERE Athletid=? AND id=?', array($athletid,$id));
        
        
        
        // UseID beschreibt den Verwendungszwecke welcher mit der VeranstalterID übereinstimmt 
         $action = $this->dbAdapter->query('UPDATE `veranstalterkonto` SET Kontostand=Kontostand+? WHERE id=?', array($wert,$useID));
        
    }
    
    public function forwardgrouptoVeranstalter($useID,$wert)
    {
        // TO-DO Fehlerabfragen
    
    
    
        $hydrator = new ClassMethods();
        // Statements funktionieren !!
    
        //$action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  verwendungszweck=?', array($useID));
        $action = $this->dbAdapter->query('DELETE FROM `athlet_buchung` WHERE verwendungszweck=?', array($useID));
    
    
    
        // UseID beschreibt den Verwendungszwecke welcher mit der VeranstalterID übereinstimmt
        $action = $this->dbAdapter->query('UPDATE `veranstalterkonto` SET Kontostand=Kontostand+? WHERE id=?', array($wert,$useID));
    
    }
    
    
    public function athletbezahlungErstellen($id,$athletid,$wert,$iban,$bic)
    {
        // TO-DO Fehlerabfragen

        $hydrator = new ClassMethods();
        
        //erzeugt datetime mit jetzigem Datum + Uhrzeit
        $date = date("Y-m-d H:i:s");
        
        
        // "gekünstelten Werte ausbessern: id,verwendungszweck
        $action = $this->dbAdapter->query('INSERT INTO athlet_buchung VALUES (?,?,?,?,?,?,?,?)', array($id,$iban,$bic,$date,$athletid,$wert,"1","1"));
	$action = $this->dbAdapter->query('INSERT INTO betreiberkonto VALUES (?,?,?)', array($id,$wert,$date));
        
    }
    
   
    
    public function iban($athletid)
    {   // IBAN aus der DB holen 
        
        
        //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` where id = ?', array($athletid));
        //ausführen des statements
        $resultstest=$action2->toarray();
        //iterator auf den ersten datensatz platzieren (ist automatisch ein array)
        
        //ausgeben der id aus dem datensatz
        return $resultstest[0]['IBAN'];
        
        
    }
    
   
    public function bic($athletid)
    {    // BIC aus der Db holen
       
       //statement erzeugen
        $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` where id = ?', array($athletid));
        //ausführen des statements
        $resultstest=$action2->toarray();
        
        return $resultstest[0]['BIC'];
    }
    
    public function getAthletenbezahlung($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $athletenbezahlung = new AthletenbezahlungEntity();
        $hydrator->hydrate($result, $athletenbezahlung);
    
        return $athletenbezahlung;
    }
	
	 public function deleteAthletenbezahlung($id) //eingefügt von TW Gruppe7, benötigt für die AthletLöschenAction
    {
        $delete = $this->sql->delete();
        $delete->where(array('Athletid' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    
}