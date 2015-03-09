<?php
namespace Starmina\Model;

use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;


class UserMapper implements ServiceLocatorAwareInterface
{
    
    protected $service_manager;
    protected $athletTable;
	protected $vereinTable;// eingefügt von TW Gruppe7
    
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
        return $this->service_manager;
    }
    
    public function __construct()
    {
        
    }

    public function getUserobject($rolle, $email)
    {

        if($rolle == 've')//Veranstalter
        {
            echo "Veranstalter";
            $veranstalter = $this->getVeranstalterMapper()->getVeranstalterEmail($email);
            print_r($veranstalter);
            return $veranstalter;
        }
		if($rolle == 'vr')//Verein eingefügt von TW Gruppe7
        {
            echo "Verein";
            $verein = $this->getVereinTable()->getVereinEmail($email);
            //print_r($verein);
            return $verein;
        }
        if($rolle == 'at')//Athlet
        {
            $athlet = $this->getAthletTable()->getAthletEmail($email);
            //print_r($athlet);
            //echo $athlet->geburtstag_athlet;
            return $athlet;
        }
    }
    
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
	
    public function getVereinTable() { //eingefügt von TW im zuge des Auslesens eines vereins aus dem Sessionmanagement
		if (! $this->vereinTable) {
			$sm = $this->getServiceLocator ();
			$this->vereinTable = $sm->get ( 'Starmina\Model\VereinTable' );
		}
		return $this->vereinTable;
	}
	 public function getAthletTable()
     {
         if (!$this->athletTable) {
             $sm = $this->getServiceLocator();
             $this->athletTable = $sm->get('Starmina\Model\AthletTable');
         }
         return $this->athletTable;
     }
}