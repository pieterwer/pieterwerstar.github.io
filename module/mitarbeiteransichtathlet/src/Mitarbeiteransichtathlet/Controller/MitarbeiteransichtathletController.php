<?php
namespace Mitarbeiteransichtathlet\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mitarbeiteransichtathlet\Model\MitarbeiteransichtathletEntity;

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
class MitarbeiteransichtathletController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    
    public function indexAction()
    {
        
        $mapper = $this->getMitarbeiteransichtathletMapper();
        return new ViewModel(array(
            'MitarbeiterAnsichtAthleten' => $mapper->fetchAll()
        ));
    }
   
    
    public function searchAction(){
    
    
        $mitarbeiteransichtathlet= new MitarbeiteransichtathletEntity();
    
    
        $request = $this->getRequest();
    
        if(isset($_REQUEST['email']) || isset($_REQUEST['name'])){
            $email2 = $_REQUEST['email'];
            $name2 = $_REQUEST['name'];
    
    
    
            $mapper = $this->getMitarbeiteransichtathletMapper();
            return new ViewModel(array(
                'Mitarbeiteransichtathlet' => $mapper->searchAthlet($email2,$name2)
    
            ));
        }
        // Auslesen der übergebenen Suchparameter
    
    
        return array(
            'Mitarbeiteransichtathlet' => NULL,
        );
    
    }

    public function getMitarbeiteransichtathletMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MitarbeiteransichtathletMapper');
    }
}