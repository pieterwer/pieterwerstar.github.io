<?php
namespace Mitarbeiteransichtveranstalter\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mitarbeiteransichtveranstalter\Model\MitarbeiteransichtveranstalterEntity;

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
class MitarbeiteransichtveranstalterController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    
    public function indexAction()
    {
        
        $mapper = $this->getMitarbeiteransichtveranstalterMapper();
        return new ViewModel(array(
            'Mitarbeiteransichtveranstalter' => $mapper->fetchAll()
        ));
    }
   
    public function searchAction(){
    
        
        $mitarbeiteransichtveranstalter = new MitarbeiteransichtveranstalterEntity();
    
    
    
        
        // die †bergabe von Werten funktioniert noch nicht
    
        $request = $this->getRequest();
    
        if(isset($_REQUEST['id']) || isset($_REQUEST['email'])){
            $id2 = $_REQUEST['id'];
            $email2 = $_REQUEST['email'];
    
    
    
            $mapper = $this->getMitarbeiteransichtveranstalterMapper();
            return new ViewModel(array(
                'Mitarbeiteransichtveranstalter1' => $mapper->searchVeranstalter($id2,$email2)
    
            ));
        }
        // Auslesen der übergebenen Suchparameter
    
    
        return array(
            'Mitarbeiteransichtveranstalter1' => NULL,
        );
    
    }
    

    public function getMitarbeiteransichtveranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MitarbeiteransichtveranstalterMapper');
    }
}