<?php
namespace Athletenhistorie\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Athletenhistorie\Model\AthletenhistorieEntity;
use Athletenhistorie\Form\AthletenhistorieForm;

/**
 * AthletenhistorieController
 *
 * @author
 *
 * @version
 *
 */
class AthletenhistorieController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {   
        //athletenID auslesen
        $id = $this->params('id');
        
        $athletenname=$this->getAthletenhistorieMapper()->getname($id);
        
        $athletenvorname=$this->getAthletenhistorieMapper()->getvorname($id);
        
        $eventnamen=$this->getAthletenhistorieMapper()->geteventname($id);
        
        $mapper = $this->getAthletenhistorieMapper();
        
        $anzahl=count($eventnamen);
        
        return new ViewModel(array(
            'athletenhistorien' => $mapper->fetchAll($id),
            'athletenname1'=>$athletenname,
            'athletenvorname1'=>$athletenvorname,
            'eventnamensarray'=>$eventnamen,
            'anzahl'=>$anzahl,
            
        ));
    }
    
    public function getAthletenhistorieMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AthletenhistorieMapper');
    }
}