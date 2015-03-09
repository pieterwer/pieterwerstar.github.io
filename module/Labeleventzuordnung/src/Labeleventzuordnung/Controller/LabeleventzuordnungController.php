<?php
namespace Labeleventzuordnung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Labeleventzuordnung\Model\LabeleventzuordnungEntity;
use Labeleventzuordnung\Form\LabeleventzuordnungForm;

// LabeleventzuordnungController
class LabeleventzuordnungController extends AbstractActionController
{
    public function indexAction()
    {
        // Rolle �berpr�fen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD"))
        {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zur�ckf�hren auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        
        $mapper = $this->getLabeleventzuordnungMapper();
        return new ViewModel(array('labeleventzuordnungen' => $mapper->fetchAll()));
    }
    
    public function editstatusAction()
    {
        // Rolle �berpr�fen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD"))
        {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zur�ckf�hren auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        
        $eventid = (int)$this->params('eventid');
        $labelid = (int)$this->params('labelid');

        // Falls die �bergebene ID nicht vorhanden ist, zur�ck zur �bersicht
        if (!$eventid || !$labelid) {
            return $this->redirect()->toRoute('labeleventzuordnung');
        }
        
        $labeleventzuordnung = $this->getLabeleventzuordnungMapper()->getLabeleventzuordnung($eventid);
    
        $form = new LabeleventzuordnungForm();
        $form->bind($labeleventzuordnung);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getLabeleventzuordnungMapper()->statusaendernLabeleventzuordnung($labeleventzuordnung);
                $this->flashMessenger()->addMessage('Label-Event-Zuordnung erfolgreich bearbeitet!');
                return $this->redirect()->toRoute('labeleventzuordnung');
            }
        }
    
        return array(
            'eventid' => $eventid,
            'labelid' => $labelid,
            'form' => $form,
            'labeleventzuordnung' => $labeleventzuordnung,
        );
    }
    
    public function deleteAction()
    {   
        // Rolle �berpr�fen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD"))
        {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zur�ckf�hren auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        
        // Speichern der �bergebenen Event-ID
        $eventid = (int) $this->params('eventid');
        
        $labeleventzuordnung = $this->getLabeleventzuordnungMapper()->getLabeleventzuordnung($eventid);
        
        // �berpr�fung, ob das Objekt existiert(NULL)
         if (!$labeleventzuordnung) {
            return $this->redirect()->toRoute('labeleventzuordnung');
        }
    
        $request = $this->getRequest();
        
        // �berpr�fen, ob der Button schon gedr�ckt wurde, und wenn ja, ob 'Ja' oder 'Nein' ausgew�hlt wurde
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                $this->getLabeleventzuordnungMapper()->deleteLabeleventzuordnung($labeleventzuordnung);
                $this->flashMessenger()->addMessage('Label-Event-Zuordnung erfolgreich entfernt!');
                return $this->redirect()->toRoute('labeleventzuordnung');
            }
            
            if ($request->getPost()->get('del') == 'Abbrechen') {
                $this->flashMessenger()->addMessage('Aktion abgebrochen!');
                return $this->redirect()->toRoute('labeleventzuordnung');
            }
    
            return $this->redirect()->toRoute('labeleventzuordnung');
        }
    
        return array('eventid' => $eventid, 'labeleventzuordnung' => $labeleventzuordnung);
    }
    
    public function getLabeleventzuordnungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LabeleventzuordnungMapper');
    }
}