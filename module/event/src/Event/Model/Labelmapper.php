<?php
namespace Event\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Event\Model\SportartEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class LabelMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'label';
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

    public function fetchAll()
    {
        $select = $this->sql->select();
        //$select->order(array('completed ASC', 'created ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new LabelEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    

    
    public function getLabel($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $label = new LabelEntity();
        $hydrator->hydrate($result, $label);
    
        return $label;
    }
    
    
    public function getEventlabelMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventlabelMapper');
    }

}