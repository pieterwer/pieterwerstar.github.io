<?php
namespace Mitarbeitereventansicht\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mitarbeitereventansicht\Model\MitarbeitereventansichtEntity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\InputFilter\Factory;
/**
 * WerbeauftragController
 *
 * @author
 *
 * @version
 *
 */
class MitarbeitereventansichtController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    
    public function indexAction()
    {
        
        $mapper = $this->getMitarbeitereventansichtMapper();
        return new ViewModel(array(
            'MitarbeiterAnsichtevent' => $mapper->fetchAll()
        ));
    }
   
   public function searchAction(){
    
        
        $mitarbeitereventansicht= new MitarbeitereventansichtEntity();


        $request = $this->getRequest();
    
        if(isset($_REQUEST['id']) || isset($_REQUEST['name'])){
            $id2 = $_REQUEST['id'];
            $name2 = $_REQUEST['name'];
    
    
    
            $mapper = $this->getMitarbeitereventansichtMapper();
            return new ViewModel(array(
                'MitarbeiterAnsichtevent' => $mapper->searchEvent($id2,$name2)
    
            ));
        }
        // Auslesen der übergebenen Suchparameter
    
    
        return array(
            'MitarbeiterAnsichtevent' => NULL,
        );
    
    }
    
    
    public function getMitarbeitereventansichtMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MitarbeitereventansichtMapper');
    }
}