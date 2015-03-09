<?php
namespace Bonusbetrag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bonusbetrag\Model\BonusbetragEntity;
use Bonusbetrag\Form\BonusbetragForm;

// LabeleventzuordnungController
class BonusbetragController extends AbstractActionController
{
    public function indexAction()
    {
        // Rolle überprüfen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD"))
        {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zurückführen auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        
        $mapper = $this->getBonusbetragMapper();
        return new ViewModel(array('bonusbetrags' => $mapper->fetchAll()));
    }
    
    public function editAction()
    {
        // Rolle überprüfen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zurückführen auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        $id = (int)$this->params('id');

        // Falls die übergebene ID nicht vorhanden ist, zurück zur Übersicht
        if (!$id) {
            return $this->redirect()->toRoute('bonusbetrag');
        }
        
        $bonusbetrag = $this->getBonusbetragMapper()->getBonusbetrag($id);
    
        $form = new BonusbetragForm();
        $form->bind($bonusbetrag);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $wert = $bonusbetrag->wert;
                if ($wert <= 0 || $wert > 100)
                {
                    $this->flashMessenger()->addMessage('Aktion fehlgeschlagen! Der Wert muss >0 und <=100 sein!');
                    return $this->redirect()->toRoute('bonusbetrag');
                }
                $this->getBonusbetragMapper()->wertaendernBonusbetrag($bonusbetrag);
                $this->flashMessenger()->addMessage('Aktion erfolgreich! Der Wert wurde ge&aumlndert!');
       
                return $this->redirect()->toRoute('bonusbetrag');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
            'bonusbetrag' => $bonusbetrag,
        );
    }
    
    public function getBonusbetragMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BonusbetragMapper');
    }
}