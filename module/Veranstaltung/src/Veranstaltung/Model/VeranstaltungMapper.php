<?php
namespace Veranstaltung\Model;

use Zend\Db\Adapter\Adapter;
use Veranstaltung\Model\VeranstaltungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Veranstaltung\Controller\VeranstaltungController;

class VeranstaltungMapper
{
    protected $tableName = 'veranstaltung';
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

        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function myVeranstaltungen($id)
    {
        $select = $this->sql->select();
        $select->where(array('veranstalterid' => $id));
            
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function saveVeranstaltung(VeranstaltungEntity $veranstaltung)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($veranstaltung);
    
        if ($veranstaltung->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $veranstaltung->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$veranstaltung->getId()) {
            $veranstaltung->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    public function getVeranstaltung($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $veranstaltung = new VeranstaltungEntity();
        $hydrator->hydrate($result, $veranstaltung);
    
        return $veranstaltung;
    }
    
    public function Veranstaltungver($verid)
    {
        $select = $this->sql->select();
        $select->where(array('veranstalterid' => $verid));
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function searchAll($name = null)
    {
        $dbAdapter = $this->dbAdapter;
        $veranstaltungname = '%'. $name .'%';
        $params = array($veranstaltungname);
        $statement = $dbAdapter->query('SELECT * FROM veranstaltung WHERE Name like ? and Status = 1 and id in(select veranstaltungsid from event)');
        $results    = $statement->execute($params);
    
        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function history($id)
    {
    
         $select = $this->sql->select();
        $select->where(array('vorgaengerid' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function historyAll($id)
    {
    
        $select = $this->sql->select();
        $select->where(array('vorgaengerid' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new VeranstaltungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function getVorlageid($eventid)
    {
        echo "Funzt";
        $select = $this->sql->select()->where(array(
            'Vorgaengerid' => $eventid
        ));
        //$select->order(array('id DESC', 'id DESC'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        if ($results->getAffectedRows() != NULL) {
            $max = array();
            foreach ($results as $result) {
                $max[] = $this->getVeranstaltung($result['id']);
            }
        } else {
            $max = array(
                new VeranstaltungEntity()
            );
        }
        foreach ($max as $m) {
            echo $m->getId();
        }
    
        return $m->getId();
    }
    
    public function getLink($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`veranstaltung` b WHERE a.id = b.bildid AND b.bildid = ?', array($bid));
        $test = $action->toArray();
    
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../../../pictures/default_veranstaltung_pic.png";
            return $link;
        }
        else
        {
            $name = $test[0]['Link'];
            $link = "../../../img/";
            $link .= $name;
            return $link;
        }
    
    }
    
    public function getLink1($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`veranstaltung` b WHERE a.id = b.bildid AND b.bildid = ?', array($bid));
        $test = $action->toArray();
    
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../pictures/default_veranstaltung_pic.png";
            return $link;
        }
        else
        {
            $name = $test[0]['Link'];
            $link = "../img/";
            $link .= $name;
            return $link;
        }
    
    }
    
    public function getLink2($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`veranstaltung` b WHERE a.id = b.bildid AND b.bildid = ?', array($bid));
        $test = $action->toArray();
    
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../../pictures/default_veranstaltung_pic.png";
            return $link;
        }
        else
        {
            $name = $test[0]['Link'];
            $link = "../../img/";
            $link .= $name;
            return $link;
        }
    
    }
    
    public function deleteVeranstaltung($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function veranstaltungbild($id, $bildid)
    {
        $action = $this->dbAdapter->query('UPDATE `veranstaltung` SET `Bildid` = ? WHERE `veranstaltung`.`id` = ?', array($bildid, $id));
    }
    //setzt die Veranstaltungen und die dazu gehörigen Events öffentlich
    public function getPublic($veranstaltung)
    {
        //Zuerst die Veranstaltung šffentlich schalten
        $action = $this->dbAdapter->query('UPDATE `veranstaltung` SET `status` = 1 WHERE `id` = ?', array($veranstaltung->getId()));
        
        //Updaten der dazugehšrigen Events
        $action = $this->dbAdapter->query('UPDATE `event` SET `status`= 1 WHERE `Veranstaltungsid` = ?', array($veranstaltung->getId()));
        
    }
    
}