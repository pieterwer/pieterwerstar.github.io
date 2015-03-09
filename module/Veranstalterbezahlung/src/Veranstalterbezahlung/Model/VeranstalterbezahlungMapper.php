<?php
namespace Veranstalterbezahlung\Model;

use Zend\Db\Adapter\Adapter;
use Veranstalterbezahlung\Model\VeranstalterbezahlungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;

class VeranstalterbezahlungMapper
{
    protected $tableName = 'veranstalter_buchung';
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

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new VeranstalterbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    
    
    public function fetchAllindividuell($id,$useid)
    {
        
    if ($id!=NULL & $useid!=NULL){
        $select = $this->sql->select();
        $select->where(array('Veranstalterid' => $id));
        $select->where(array('Verwendungszweck' => $useid));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        $entityPrototype = new VeranstalterbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    if ($id==NULL & $useid!=NULL){
        $select = $this->sql->select();
        
        $select->where(array('Verwendungszweck' => $useid));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new VeranstalterbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    if ($id!=NULL & $useid==NULL){
        $select = $this->sql->select();
        $select->where(array('Veranstalterid' => $id));
        
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new VeranstalterbezahlungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
        
        
    }
    
    
    
    public function backtoVerein($id,$vereinid,$wert)
    //Funktion überweist bestehende Buchung zurück zum Verein    (im falle dass der Verein alle Athleten abmelden will)
    {
     
 
       // Statements funktionieren !!
        $action = $this->dbAdapter->query('DELETE FROM `verein_buchung` WHERE Vereinid=? AND id=?', array($vereinid,$id));
        $action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  id=?', array($id));
        
        //unnötig
        
        // Geld auf Vereinskonto überweisen
        //$action = $this->dbAdapter->query('UPDATE `verein_konto` SET `Wert`=`Wert`+? WHERE `vereinid`=?', array($wert,$vereinid));
     
    }
    
    
    public function forwardtoVeranstalter($id,$vereinid,$useID,$wert)
    {
        
        $hydrator = new ClassMethods();
        // Statements funktionieren !!
        
        $action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  id=?', array($id));
        $action = $this->dbAdapter->query('DELETE FROM `verein_buchung` WHERE id=? AND Vereinid=?' , array($id,$vereinid));
        
        
        //unnötig
        // UseID beschreibt den Verwendungszwecke welcher mit der VeranstalterID übereinstimmt 
         //$action = $this->dbAdapter->query('UPDATE `veranstalterkonto` SET Kontostand=Kontostand+? WHERE id=?', array($wert,$useID));
        
    }
    
    public function forwardgrouptoVeranstalter($useID,$wert)
    {
    
        $hydrator = new ClassMethods();
        // Statements funktionieren !!
    
        $action = $this->dbAdapter->query('DELETE FROM `betreiberkonto` WHERE  Verwendungszweck=?', array($useID));
        $action = $this->dbAdapter->query('DELETE FROM `verein_buchung` WHERE Verwendungszweck=?' , array($useID));
    
    
        //unnötig
        // UseID beschreibt den Verwendungszwecke welcher mit der VeranstalterID übereinstimmt
        //$action = $this->dbAdapter->query('UPDATE `veranstalterkonto` SET Kontostand=Kontostand+? WHERE id=?', array($wert,$useID));
    
    }
    

    public function vereinbezahlungErstellen($id,$veranstaltungid,$vereinid,$wert,$iban,$bic)
    {
        // TO-DO Fehlerabfragen
    
        $hydrator = new ClassMethods();
    
        //erzeugt datetime mit jetzigem Datum + Uhrzeit
        $date = date("Y-m-d H:i:s");
    
    
        // "gekünstelten Werte ausbessern: verwendungszweck,verwendungsart
        $action = $this->dbAdapter->query('INSERT INTO verein_buchung VALUES (?,?,?,?,?,?,?,?)', array($id,$vereinid,$iban,$bic,$wert,$date,$veranstaltungid,"1"));
    
    }
    
    public function iban($vereinid)
    {   // IBAN aus der DB holen
    
    
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `verein` where id = ?', array($vereinid));
    //ausführen des statements
    $resultstest=$action2->toarray();
    //iterator auf den ersten datensatz platzieren (ist automatisch ein array)
    
    //ausgeben der id aus dem datensatz
    return $resultstest[0]['IBAN'];
    
    
    }
    
     
    public function bic($vereinid)
    {    // BIC aus der Db holen
     
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `verein` where id = ?', array($vereinid));
    //ausführen des statements
    $resultstest=$action2->toarray();
    
    return $resultstest[0]['BIC'];
    }
    

    public function checkbuchungsid($id)
    {    // BIC aus der Db holen
     
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `verein_buchung` where id = ?', array($id));
    //ausführen des statements
    $resultstest=$action2->toarray();
    
    return $resultstest[0]['BIC'];
    }
    
    public function checkveranstalter($id)
    {    // BIC aus der Db holen
     
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `veranstalter` where id = ?', array($id));
    //ausführen des statements
    $resultstest=$action2->toarray();
    
    return $resultstest[0]['BIC'];
    }
    
    public function checkverein($id)
    {    // BIC aus der Db holen
     
    //statement erzeugen
    $action2 = $this->dbAdapter->query('SELECT * FROM `verein` where id = ?', array($id));
    //ausführen des statements
    $resultstest=$action2->toarray();
    
    return $resultstest[0]['BIC'];
    }
    
    public function getVereinbezahlung($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $vereinbezahlung = new VereinbezahlungEntity();
        $hydrator->hydrate($result, $vereinbezahlung);
    
        return $vereinbezahlung;
    }
}