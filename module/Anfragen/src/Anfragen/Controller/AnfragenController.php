<?php
namespace Anfragen\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AnfragenController extends AbstractActionController
{    
    public function indexAction()
    {
        // Rolle überprüfen
        $user = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Zurückführen auf die Startseite
            return $this->redirect()->toRoute('auth');
        }
        return new ViewModel(array('anfragen'));
    }
}