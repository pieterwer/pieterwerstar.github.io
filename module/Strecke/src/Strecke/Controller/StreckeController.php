<?php
namespace Strecke\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Strecke\Model\StreckeEntity;
use Strecke\Form\StreckeForm;
use Strecke\Form\UploadForm;

/**
 * StreckeController
 *
 * @author
 *
 * @version
 *
 */
class StreckeController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getStreckeMapper();
        return new ViewModel(array(
            'strecken' => $mapper->fetchAll()
        ));
    }
  
    public function addAction(){
        $eventid = (int)$this->params('id');
        echo $eventid;
        if (!$eventid) {
//             echo "test";
//             echo $eventid;
            return $this->redirect()->toRoute('myveranstaltung');
        }
//         echo $eventid;
        
        $event = $this->getEventMapper()->getEvent($eventid);
        if (!$event) {
            return $this->redirect()->toRoute('event', array('action' => 'show'));
        }
        
        $form = new StreckeForm();
        $strecke = new StreckeEntity();
        $strecke->setEventid($eventid);
    
        $form->bind($strecke);
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getStreckeMapper()->saveStrecke($strecke);
                $this->flashMessenger()->addMessage('Strecke '. $strecke->getId() .' erfolgreich angelegt');
                
                // Redirect to list of tasks
                return $this->redirect()->toRoute('strecke', array(
                    'action' => 'show',
                    'id' => $strecke->getId(),
                ));
            }
        }
        return array('id' => $eventid,'form' => $form);
    }
    
    public function showAction(){
        $streckeid = (int)$this->params('id');
        if (!$streckeid) {
            return $this->redirect()->toRoute('strecke');
        }
        // Strecke Auslesen
        $strecke = $this->getStreckeMapper()->getStrecke($streckeid);
        if (!$strecke) {
            return $this->redirect()->toRoute('veranstaltung');
        } 
        
        //Event auslesen
        $event = $this->getEventMapper()->getEvent($strecke->getEventid());
        if (!$event) {
            return $this->redirect()->toRoute('event');
        }
        
        //Veranstaltung auslesen
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($event->getVeranstaltungsid());
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => 'show'));
        }
    
        //         $event = $this->getEventMapper()->getEvent($id);
        //         $date = date_create($event->getDatum());
        //         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'event' => $event , 'veranstaltung' => $veranstaltung, 'strecke' => $strecke
    
        ));
    
    }
    
    public function getStreckeMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('StreckeMapper');
    }
    
    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }

    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }
    
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
    }
    
}