<?php
namespace Pwvergessen\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Pwvergessen\Model\PwvergessenEntity;
use Pwvergessen\Form\PwvergessenForm;

class PwvergessenController extends AbstractActionController
{
    public function indexAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new PwvergessenForm($dbAdapter);
        $pwvergessen = new PwvergessenEntity();
        $form->bind($pwvergessen);
         
        $request = $this->getRequest();
        // Abfrage, ob das Formular gesendet wurde
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            
            // Abfrage, ob das Formular gültig ist
            if ($form->isValid())
            {   
                $email = $pwvergessen->email;
                // Abfrage, ob überhaupt etwas eingegeben wurde
                if($email == "")
                {
                    $this->flashMessenger()->addMessage('Aktion fehlgeschlagen!<br>
                        Sie m&uumlssen eine g&uumlltige Email-Adresse eingeben!');
                    return $this->redirect()->toRoute('pwvergessen');
                }
                
                //Fehlerabfrage, ob Email überhaupt vorhanden ist
                $emailchecked = $this->getPwvergessenMapper()->checkEmail($pwvergessen);
                if ($email != $emailchecked)
                {
                    $this->flashMessenger()->addMessage('Aktion fehlgeschlagen!<br>
                        Entweder ist die Email-Adresse im System nicht vorhanden oder sie haben falsche Eingaben gemacht! ');
                    return $this->redirect()->toRoute('pwvergessen');
                }
                
                $this->getPwvergessenMapper()->updatePW($pwvergessen);
                $this->flashMessenger()->addMessage('Aktion erfolgreich!<br>
                    Sehen Sie nun in Ihrem Email-Konto nach.<br>
                    Mit den darin enthaltenen Daten k&oumlnnen Sie sich wieder im System registrieren!');
                return $this->redirect()->toRoute('pwvergessen');
            }
            else return $this->redirect()->toRoute('home');
        }
        return array('form' => $form,
            'pwvergessen' => $pwvergessen);
    }
    
    public function getPwvergessenMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('PwvergessenMapper');
    }

}