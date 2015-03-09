<?php
namespace Event\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class EventlabelMapper implements ServiceLocatorAwareInterface
{

    protected $tableName = 'event_label_zuordnung';

    protected $dbAdapter;

    protected $sql;

    protected $service_manager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service_manager;
    }

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    
    // ABspeichern der Zuordnung von event und lizenz
    public function saveEventzu($eventid, $labels)
    {
        
        // insert action
        $action = $this->sql->insert();
        // unset($data['id']);
        foreach ($labels as $label) {
            $data = array(
                'eventid' => $eventid,
                'labelid' => $label,
                'status' => Null
            );
        $action->values($data);
        
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        }
        
        return $result;
    }

    public function getKategorienbezeichnung($eventid)
    {
        $select = $this->sql->select()->where(array(
            'eventid' => $eventid
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        if ($results->getAffectedRows() != NULL) {
            $kategorien = array();
            foreach ($results as $result) {
                $kategorien[] = $this->getKategorieMapper()->getKategorie($result['Eventkategorieid']);
            }
        } else {
            $kategorien = array(
                new KategorieEntity()
            );
        }
        return $kategorien;
    }

    public function getLabels($eventid, $check = 1)
    {
        $select = $this->sql->select()->where(array(
            'eventid' => $eventid, 'Status' => $check
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        if ($results != NULL) {
            
            $labels = array();
            foreach ($results as $result) {
                $id = $result['Labelid'];
                $labels[] = $this->getLabelMapper()->getLabel($id);
            }
            
        } else {
            $labels = array(
                new LabelEntity()
            );
        }
        
        return $labels;
    }


    public function getLabelMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LabelMapper');
    }
}