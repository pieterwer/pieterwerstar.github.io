<?php
namespace Veranstalterverifizieren\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstalterverifizieren\Model\VeranstalterverifizierenEntity;
use Veranstalterverifizieren\Form\VeranstalterverifizierenForm;

class VeranstalterverifizierenController extends AbstractActionController
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
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new VeranstalterverifizierenForm($dbAdapter);
        $veranstalterverifizieren = new VeranstalterverifizierenEntity();
        $form->bind($veranstalterverifizieren);
         
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $this->getVeranstalterverifizierenMapper()->speichernVeranstalter($veranstalterverifizieren);
                $this->flashMessenger()->addMessage('Aktion erfolgreich!');
                return $this->redirect()->toRoute('veranstalterverifizieren');
            }
        }
        return array('form' => $form,
            'veranstalterverifizieren' => $veranstalterverifizieren);
    }
    
    public function getVeranstalterverifizierenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterverifizierenMapper');
    }
}