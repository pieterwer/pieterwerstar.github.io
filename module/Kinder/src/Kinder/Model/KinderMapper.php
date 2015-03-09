<?php
namespace Kinder\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Kinder\Model\KinderEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class KinderMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'kindtabelle';
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

        $entityPrototype = new KinderEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
//         print_r($resultset);
        return $resultset;
    }
    
    public function fetchChild($id)
    {
        $select = $this->sql->select();
        $select->where(array('athletid' => $id ));
        //$select->order(array('completed ASC', 'created ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
    
        $entityPrototype = new KinderEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function saveKind(KinderEntity $kind)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($kind);
    
        if ($kind->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $kind->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$kind->getId()) {
            $kind->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    
    public function getKind($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $kind = new KinderEntity();
        $hydrator->hydrate($result, $kind);
    
        print_r($kind);
        return $kind;
    }
    
    public function deleteKind($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
}