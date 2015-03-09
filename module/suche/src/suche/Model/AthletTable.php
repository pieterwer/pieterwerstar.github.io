<?php
namespace Suche\Model;

use Zend\Db\TableGateway\TableGateway;

class AthletTable
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

    public function getAthletId($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getAthletName($name)
    {

        $resultSet = $this->tableGateway->select(array('Name'=> $name)); //ohne where....funktionierts
        return $resultSet;
    }
    
    public function getAthletVorname($vorname)
    {
        $resultSet = $this->tableGateway->select(array('Vorname'=> $vorname)); //ohne where....funktionierts
        return $resultSet;
    }
    
    public function getAthletVornameName($vorname, $name)
    {
        
        //Select mit where vorname und nachname
        $resultSet = $this->tableGateway->select(array('Vorname'=> $vorname),array('Name'=> $name, 'Vorname'=>$vorname)); //ohne where....funktionierts
        return $resultSet;
    }
    

    public function getAthletTable()
    {
        if (!$this->athletTable) {
            $sm = $this->getServiceLocator();
            $this->athletTable = $sm->get('Athlet\Model\AthletTable');
        }
        return $this->athletTable;
    }
    
    public function searchAthletName($name)
    {

            $resultSet=$this->tableGateway->select(array('Name'=> $name));

            return $resultSet;

    //Abfrage mit beiden Where bedingungen
        
    
    }
    
    
    protected $athletTable;
}