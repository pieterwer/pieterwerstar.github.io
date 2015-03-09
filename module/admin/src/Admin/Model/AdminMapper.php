<?php
namespace Admin\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Admin\Model\AdminEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class AdminMapper implements ServiceLocatorAwareInterface
{
    protected $tableName = 'admin';
    protected $dbAdapter;
    protected $sql;
    protected $service_manager;

    
//Getter und Setter
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->service_manager;
    }

 
//Konstruktor
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    
//Adminliste holen
    public function fetchAll()
    {
        $select = $this->sql->select();
        //$select->order(array('completed ASC', 'created ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new AdminEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        $resultset->buffer();
    }

    
//Admin hinzufügen oder bearbeiten
    public function saveAdmin(AdminEntity $admin)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($admin);
        
        if ($admin->getId()) {
            // update action
            $action = $this->sql->update();
            $zuordnung = $this->sql;
            $action->set($data);
            $action->where(array('id' => $admin->getId()));
            
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$admin->getId()) {
            $admin->setId($result->getGeneratedValue()); 
        }
        return $result; 
    }

//Admin anzeigen  
    public function getAdmin($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
        $hydrator = new ClassMethods();
        $admin = new AdminEntity();
        $hydrator->hydrate($result, $admin);
   
        return $admin;
    }

    
//Admin löschen
    public function deleteAdmin($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
  
}