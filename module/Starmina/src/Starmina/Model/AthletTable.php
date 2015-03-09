<?php

// in Table.phps hydrator oder TableGateway Verfahren ??? (PR, 12.12.14)

namespace Starmina\Model;

 use Zend\Db\Adapter\Adapter;
 use Zend\Stdlib\Hydrator\ClassMethods;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Select;
 use Zend\Db\ResultSet\HydratingResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\ServiceManager\ServiceLocatorAwareInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;
 
class AthletTable implements ServiceLocatorAwareInterface
{
    protected $tableGateway;
    
    protected $service_manager;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->service_manager;
    }
	
     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
	
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getAthlet($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
         throw new \Exception("Could not find row $id");
		 }
         return $row;
     }
	  
	 
	  public function getAthletEmail($email)
     {
         //echo "Athletemail";
         $rowset = $this->tableGateway->select(array('Email' => $email));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $email");
         }
         return $row;
     }
	  
public function getEmail($id)
    {
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	$action=$dbAdapter->query('SELECT `Email` FROM `athlet` WHERE `id` = ?', array($id)); 
    	$test=$action->toArray();
    	$Email=$test[0]['Email'];
        
    return $Email;
    }
	
     public function saveAthlet(Athlet $at)
     {
		 //var_dump($at);
		 
		 $data = array(
		 //'id' => $at->id_athlet, 
		 'Vorname' => $at->Vorname, 
		 'Name' => $at->Name, 
		 'Titel' => $at->Titel, 
		 'Zusatz' => $at->Zusatz, 
		 'Geschlecht' => $at->Geschlecht, 
		 'Geburtstag' => $at->Geburtstag, 
		 'Werbung' => $at->Werbung, 
		 'Historie' => $at->Historie, 
		 'Umkreis' => $at->Umkreis, 
		 'Telefonnummer1' => $at->tel1landauswahl_athlet . $at->Telefonnummer1, 
		 'Telefonnummer2' => $at->tel2landauswahl_athlet . $at->Telefonnummer2, 
		 'Telefonnummer3' => $at->tel3landauswahl_athlet . $at->Telefonnummer3, 
		 'Fax' => $at->faxlandauswahl_athlet . $at->Fax, 
		 'Firma' => $at->Firma, 
		 /*'' => $athlet->name_athlet_bkih*/ 
		 'IBAN' => $at->IBAN, 
		 'BIC' => $at->BIC, 
		 'Bildid' => $at->bildid, 
		 'Email' => $at->Email, 
		 'Status' => $at->status,
		 /*Passwort*/
		 //'Bildname' => $at->bild_athlet['name'],
		 );
		 
		 
		 //file_put_contents('/Users/alexandergiedt/Desktop/out.txt', "hallo\n");
		 
		 $this->tableGateway->insert($data);
		 
		 
		 return $this->tableGateway->lastInsertValue; 
     }
	 
	  public function updateAthlet( $athlet)
     {
		 //var_dump($at);
		 
		 $data = array(
		 //'id' => $athlet->id, 
		 'Vorname' => $athlet->Vorname, 
		 'Name' => $athlet->Name, 
		 'Titel' => $athlet->Titel, 
		 'Zusatz' => $athlet->Zusatz, 
		 'Geschlecht' => $athlet->Geschlecht, 
		 'Geburstag' => $athlet->Geburstag, 
		 'Werbung' => $athlet->Werbung, 
		 'Historie' => $athlet->Historie, 
		 'Umkreis' => $athlet->Umkreis, 
		 'Telefonnummer1' => $athlet->tel1landauswahl_athlet . $athlet->Telefonnummer1, 
		 'Telefonnummer2' => $athlet->tel2landauswahl_athlet . $athlet->Telefonnummer2, 
		 'Telefonnummer3' => $athlet->tel3landauswahl_athlet . $athlet->Telefonnummer3, 
		 'Fax' => $athlet->faxlandauswahl_athlet . $athlet->Fax, 
		 'Firma' => $athlet->Firma, 
		 /*'' => $athlet->name_athlet_bkih*/ 
		 'IBAN' => $athlet->IBAN, 
		 'BIC' => $athlet->BIC, 
		 'Bildid' => $athlet->bildid, 
		 'Email' => $athlet->Email, 
		 /*Passwort*/
		 //'Bildname' => $at->bild_athlet['name'],
		 );
 
$this->tableGateway->update ( $data, array (
				'id' => $athlet->id) );
	 }
		 
		
     public function deleteAthlet($id)
     {
		 
         $this->tableGateway->delete(array('id' => (int) $id));
     }
	 
	 
 }