<?php
namespace Starmina\Model;

 use Zend\Db\Adapter\Adapter;
 use Zend\Stdlib\Hydrator\ClassMethods;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Select;
 use Zend\Db\ResultSet\HydratingResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\ServiceManager\ServiceLocatorAwareInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;
 
 $db = (array(
     'driver' => 'Pdo',
     'dsn' => 'mysql:dbname=starminadb;host=localhost',
     'username'  => 'root',
     'password'  => '',
     'port' => 3306,
 ));
 

class GutscheincodeTable implements ServiceLocatorAwareInterface
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

        //Warum funktioniert Query nicht ???? filter gehen nicht
       $resultSet = $this->tableGateway->select(); //ohne where....funktionierts
        return $resultSet;
    }
    
    public function fetchCode($id)
    {
        $resultSet = $this->tableGateway->select(array('id'=> $id)); //ohne where....funktionierts
        return $resultSet;
    }

    public function getGutscheincode($gutscheincode)
    {
        $abfragecode  = (int) $gutscheincode;
        //wahrscheinlich fehler nimmt falschen Table
        $rowset = $this->tableGateway->select(array('id' => $abfragecode));
        $row = $rowset->current();
        
        
        //if 
        if (!$row) {
            throw new \Exception("Could not find row $gutscheincode");
        }
        return $row;
    }
        
    
    //Neu am 10.12.14
    public function generarteAndInsertGutscheincode ($gutscheincode, $randomGutscheincode)
    {
        //ZufŠlliger Gutscheincode wird erzeugt
        
        $gutscheincode->id=$randomGutscheincode;
        $data = array (
          'id' => $gutscheincode->id,  
          'Wert'=> $gutscheincode ->wert,
          'Status' => 'O',
          //Status 'N' = neu  
            
        );
        //in DB schreiben
        $this->tableGateway->insert($data);
        //fetch
        $resultSet = $this->tableGateway->select();//->where(array('status= O'));
        return $resultSet;
    }
    //Ende neu
    
    public function deleteGutscheincode($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    
    public function generateRandomCode()
    {
        //ZufŠlliger Gutscheincode wird erzeugt
        $randomGutscheincode = rand(100000000,999999999);
        return $randomGutscheincode;
    }
    
    public function checkGueltigkeitGutscheincode($gutscheincode)
    {
        $resultSet = $this->tableGateway->select(array('id'=> $gutscheincode)); 
        if ($gutscheincode->status=='O')
            
        return $resultSet;
    }
    
    public function fetchOpenGutscheincodes()
    {
        $resultSet = $this->tableGateway->select(array('Status'=> 'O')); 
        return $resultSet;
    }
    
    public function fetchClosedGutscheincodes()
    {
        $resultSet = $this->tableGateway->select(array('Status'=> 'E'));
        return $resultSet;
    }
    
    public function deactivateGutscheincode($id)
    {   
        //in DB schreiben
        $this->tableGateway->update(
            array('Status' => 'E'),
            array('id'=>$id)                                           
        );
        //fetch
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getGutscheinwert($id)
    {//
//        $gutscheincode = $this->tableGateway->select(array('id'=> $id)); 
//        $test = $gutscheincode->toArray();
//        if($test[0]['Status'] != 'O')
//            $wert=$test[0]['Wert'];
//        else 
//            $wert=0;
//
//        return $wert;


    $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'); // verändert durch TW Gruppe 7 am 29.12.14
    $action=$dbAdapter->query('SELECT `Wert` FROM `gutscheincode` WHERE `id` = ?', array($id)); 
    $test=$action->toArray();
    $wert=$test[0]['Wert'];
	return $wert;
    }
    
    public function getAthletGuthabenKontostand($athletid)
    {
        //KONTOSTAND SOLL GEHOLT WERDEN
         $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    $action=$dbAdapter->query('SELECT `Kontostand` FROM `athlet_guthaben_konto` WHERE `Athletid` = ?', array($athletid)); 
    $test=$action->toArray();
    $kontostand=$test[0]['Kontostand'];
        
    return $kontostand;
    }
    
    public function updateAthletGuthabenkontostand ($athletid, $neuerKontostand)
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        //KONTOSTAND SOLL UPGEDATED WERDEN
        $update=$dbAdapter->query('UPDATE `athlet_guthaben_konto` SET `Kontostand` = ? WHERE `Athletid` = ?', array($neuerKontostand, $athletid));
        
        return $update;
        
        
    }
    
           

}