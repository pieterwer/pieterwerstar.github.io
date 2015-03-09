<?php
namespace Veranstalterbezahlung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstalterbezahlung\Model\VeranstalterbezahlungEntity;
use Veranstalterbezahlung\Form\VeranstalterbezahlungForm;

/**
 * VeranstalterController
 *
 * @author
 *
 * @version
 *
 */
class VeranstalterbezahlungController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getVeranstalterbezahlungMapper();
        return new ViewModel(array(
            'veranstalterbezahlungen' => $mapper->fetchAll()
        ));
    }
    
    public function searchAction(){
    
        
        $veranstalterbezahlung = new VeranstalterbezahlungEntity();
        
        // die †bergabe von Werten funktioniert noch nicht
    
        //mit id ist hier die Vereinsid gemeint
    
        if(isset($_REQUEST['id'])){
            $id1 = $_REQUEST['id'];
            $useid1 = $_REQUEST['useid'];
            $mapper = $this->getVeranstalterbezahlungMapper();
            return new ViewModel(array(
                'veranstalterbezahlungen' => $mapper->fetchAllindividuell($id1,$useid1)
    
            ));
        }  else{
            return array(
                'veranstalterbezahlungen' => NULL,
            );
        }
    
    }
    
    public function getVeranstalterbezahlungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterbezahlungMapper');
    }
}