<?php
namespace 
Vereinsuche\Model;

use Zend\Db\TableGateway\TableGateway;

class VereinTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function getVereinId($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getVereinName($name)
    {
    
        $resultSet = $this->tableGateway->select(array('Name'=> $name)); //ohne where....funktionierts
        return $resultSet;
    }
    
    public function getAthletNameId($name, $id)
    {
    
        //Select mit where vorname und nachname
        $resultSet = $this->tableGateway->select(array('Name'=> $name),array('Name'=> $name, 'id'=>$id)); //ohne where....funktionierts
        return $resultSet;
    }
    

}