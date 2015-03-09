<?php
namespace Cashbackmultiplikator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cashbackmultiplikator\Model\CashbackmultiplikatorEntity;
use Cashbackmultiplikator\Form\CashbackmultiplikatorForm;

// LabeleventzuordnungController
class CashbackmultiplikatorController extends AbstractActionController
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
        
        $mapper = $this->getCashbackmultiplikatorMapper();
        return new ViewModel(array('cashbackmultiplikatoren' => $mapper->fetchAll()));
    }
    
    public function editAction()
    {
        // Rolle �berpr�fen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD"))
        {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zur�ckf�hren auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        
        // Falls die �bergebene ID nicht vorhanden ist, zur�ck zur �bersicht
        $id = (int)$this->params('id');
        if (!$id)
        {
            return $this->redirect()->toRoute('cashbackmultiplikator');
        }
        
        $cashbackmultiplikator = $this->getCashbackmultiplikatorMapper()->getCashbackmultiplikator($id);
    
        $form = new CashbackmultiplikatorForm();
        $form->bind($cashbackmultiplikator);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCashbackmultiplikatorMapper()->statusaendernCashbackmultiplikator($cashbackmultiplikator);
                $this->flashMessenger()->addMessage('Cashback-Aktion erfolgreich bearbeitet!');
                return $this->redirect()->toRoute('cashbackmultiplikator');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
            'cashbackmultiplikator' => $cashbackmultiplikator,
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
        $id = (int) $this->params('id');
        
        $cashbackmultiplikator = $this->getCashbackmultiplikatorMapper()->getCashbackmultiplikator($id);
        
        // �berpr�fung, ob das Objekt existiert(NULL)
         if (!$cashbackmultiplikator) {
            return $this->redirect()->toRoute('cashbackmultiplikator');
        }
    
        $request = $this->getRequest();
        
        // �berpr�fen, ob der Button schon gedr�ckt wurde, und wenn ja, ob 'Ja' oder 'Nein' ausgew�hlt wurde
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                $this->getCashbackmultiplikatorMapper()->deleteCashbackmultiplikator($cashbackmultiplikator);
                $this->flashMessenger()->addMessage('Loeschen erfolgreich!');
                return $this->redirect()->toRoute('cashbackmultiplikator');
            }
            if($request->getPost()->get('del') == 'Abbrechen') {
                $this->flashMessenger()->addMessage('Aktion abgebrochen!');
                return $this->redirect()->toRoute('cashbackmultiplikator');
            }
        }
    
        return array('id' => $id, 'cashbackmultiplikator' => $cashbackmultiplikator);
    }
    
    public function getCashbackmultiplikatorMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('CashbackmultiplikatorMapper');
    }
}