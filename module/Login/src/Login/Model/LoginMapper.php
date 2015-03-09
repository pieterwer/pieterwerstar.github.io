<?php
namespace Login\Model;

use Zend\Db\Adapter\Adapter;
use Login\Model\LoginEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class LoginMapper
{
    protected $tableName = 'logindaten';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function checkLogin($email,$passwort)
    {
        $select = $this->sql->select();
        $select->where(array('Email' => $email));
        $select->where(array('Passwort' => $passwort));
               // ->and
               // ->where(array('Passwort' => $passwort));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        
        
        if (!$result) {
            return FALSE;
        }
        
        $hydrator = new ClassMethods();
        $login = new LoginEntity();
        $hydrator->hydrate($result, $login);
       
        return TRUE;
    }
    
    public function setLoginData($email,$passwort)
    {
      

        $select = $this->sql->select();
        $select->where(array('Email' => $email));
        
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
        
        $hydrator = new ClassMethods();
        
        $user = LoginEntity::getInstance();
        
        $hydrator->hydrate($result, $user);
        
        $user->setLogedin(TRUE);
        
        return $user;
    }
    
    
    
}