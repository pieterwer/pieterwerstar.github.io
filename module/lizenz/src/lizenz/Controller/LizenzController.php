<?php
namespace Lizenz\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Lizenz\Model\LizenzEntity;
use Lizenz\Form\LizenzForm;

class LizenzController extends AbstractActionController
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
        $form = new LizenzForm($dbAdapter);
        $liz = new LizenzEntity();
        $form->bind($liz);
         
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $this->getLizenzMapper()->saveLizenz($liz);
                $this->flashMessenger()->addMessage('Aktion erfolgreich!');
                return $this->redirect()->toRoute('lizenz');
            }
        }
        return array('form' => $form,
            'lizenz' => $liz);
    }
    
    public function getLizenzMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LizenzMapper');
    }
}