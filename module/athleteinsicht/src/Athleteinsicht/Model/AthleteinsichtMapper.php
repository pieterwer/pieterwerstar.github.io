<?php
namespace Athleteinsicht\Model;

use Zend\Db\Adapter\Adapter;
use Athleteinsicht\Model\AthleteinsichtEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class AthleteinsichtMapper
{
    protected $tableName = 'athlet';
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

        $entityPrototype = new AthleteinsichtEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function fetchAllZuordnung($id)
    {
        $action = $this->dbAdapter->query('SELECT * FROM `athleten_werbeauftraege_zuordnung` WHERE Athletid=?', array($id));
        $resultstest=$action->toarray();
        
        return $resultstest;
    }
    
    
    public function Athletanlegen($id2,$name2,$vorname2,$titel2,$zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$passwort2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2)
    {
        $action1 = $this->dbAdapter->query('INSERT INTO `logindaten`(`Email`, `Passwort`, `Rolle`) VALUES (?,?,?)', array($email2,$passwort2,"AT"));
        
        $action2 = $this->dbAdapter->query('INSERT INTO `bild` VALUES (?,?,?)', array($id2,"",""));
        
        $action3 = $this->dbAdapter->query('INSERT INTO `athlet`(`id`, `Name`, `Vorname`, `Titel`, `Zusatz`, `Geburtstag`, `Geschlecht`, `Telefonnummer1`, `Telefonnummer2`, `Telefonnummer3`, `Fax`, `Email`,`Bildid`, `Firma`, `IBAN`, `BIC`, `Historie`, `Umkreis`, `Werbung`, `Status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($id2,$name2,$vorname2,$titel2,$zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$id2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2));
    
    }
    
    
    
    
    public function getAthlet($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $athlet = new AthleteinsichtEntity();
        $hydrator->hydrate($result, $athlet);
    
        return $athlet;
    }
    
    
    
 
    
    public function deleteAthlet($id,$email)
    {
        
        
        $action = $this->dbAdapter->query('DELETE FROM `athlet` WHERE `Email`=?', array($email));
        
        $action = $this->dbAdapter->query('DELETE FROM `logindaten` WHERE `Email`=?', array($email));
      
    }
    
    public function updateAthlet($id2,$name2,$vorname2,$titel2,$Zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2,$passwort2)
    {
    
    
        $action = $this->dbAdapter->query('UPDATE `athlet` SET `id`=?,`Name`=?,`Vorname`=?,`Titel`=?,`Zusatz`=?,`Geburtstag`=?,`Geschlecht`=?,`Telefonnummer1`=?,`Telefonnummer2`=?,`Telefonnummer3`=?,`Fax`=?,`Email`=?,`Firma`=?,`IBAN`=?,`BIC`=?,`Historie`=?,`Umkreis`=?,`Werbung`=?,`Status`=? WHERE `id`=?', array($id2,$name2,$vorname2,$titel2,$Zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2,$id2));
        
        
        
      //  $action2 = $this->dbAdapter->query('UPDATE `logindaten` SET `Passwort`=? WHERE `Email`=?', array($passwort2,$email2));
        
    }
    
    public function checkEmailAthlet($Email)
    {   
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` WHERE Email=?',array($Email));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    public function checkEmailLogindaten($Email)
    {   
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `logindaten` WHERE Email=?',array($Email));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
    public function checkId($id)
    {   // Überprüft ob es den Veranstalter überhaupt gibt
    
    $action2 = $this->dbAdapter->query('SELECT * FROM `athlet` WHERE id=?',array($id));
    
    $resultstest=$action2->toarray();
    
    return $resultstest;
    }
    
}