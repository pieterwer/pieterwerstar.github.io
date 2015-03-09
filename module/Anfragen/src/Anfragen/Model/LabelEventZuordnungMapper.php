<?php
namespace Anfragen\Model;

use Zend\Db\Adapter\Adapter;
use Anfragen\Model\LabelEventZuordnungEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;

class LabelEventZuordnungMapper
{
    protected $tableName = 'event_label_zuordnung';
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

        $entityPrototype = new LabelEventZuordnungEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveLabelEventZuordnung(LabelEventZuordnungEntity $labeleventzuordnung)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($labeleventzuordnung);
    
        if ($labeleventzuordnung->getEventId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('eventid' => $labeleventzuordnung->getEventId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['eventid']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$labeleventzuordnung->getEventId()) {
            $labeleventzuordnung->setEventId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    public function getLabelEventZuordnung($EventId)
    {
        $select = $this->sql->select();
        $select->where(array('eventid' => $EventId));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $labeleventzuordnung = new LabelEventZuordnungEntity();
        $hydrator->hydrate($result, $labeleventzuordnung);
    
        print_r($labeleventzuordnung);
        return $labeleventzuordnung;
    }
    
    public function getLink($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`shop` b WHERE a.id = b.artikelbildid AND b.artikelbildid = ?', array($bid));
        $test = $action->toArray();

        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../pictures/default_pic.jpg";
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
        
    public function deleteLabelEventZuordnungMapper($EventId)
    {
        $delete = $this->sql->delete();
        $delete->where(array('eventid' => $EventId));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }    
}