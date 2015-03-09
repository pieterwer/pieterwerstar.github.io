<?php
namespace Hilfe\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Hilfe\Model\HilfeEntity;
use Hilfe\Form\HilfeForm;

class HilfeController extends AbstractActionController
{
    public function indexAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new HilfeForm($dbAdapter);
        $Hilfe = new HilfeEntity();
        $form->bind($Hilfe);
         
        $request = $this->getRequest();
        // Abfrage, ob das Formular gesendet wurde
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            
            // Abfrage, ob das Formular gültig ist
            if ($form->isValid())
            {   
                $email = $Hilfe->email;
                // Abfrage, ob überhaupt etwas eingegeben wurde
                if($email == "")
                {
                    $this->flashMessenger()->addMessage('Aktion fehlgeschlagen!<br>
                        Sie m&uumlssen eine g&uumlltige Email-Adresse eingeben!');
                    return $this->redirect()->toRoute('Hilfe');
                }
                
                //Fehlerabfrage, ob Email überhaupt vorhanden ist
                $emailchecked = $this->getHilfeMapper()->checkEmail($Hilfe);
                if ($email != $emailchecked)
                {
                    $this->flashMessenger()->addMessage('Aktion fehlgeschlagen!<br>
                        Entweder ist die Email-Adresse im System nicht vorhanden oder sie haben falsche Eingaben gemacht! ');
                    return $this->redirect()->toRoute('Hilfe');
                }
                
                $this->getHilfeMapper()->updatePW($Hilfe);
                $this->flashMessenger()->addMessage('Aktion erfolgreich!<br>
                    Sehen Sie nun in Ihrem Email-Konto nach.<br>
                    Mit den darin enthaltenen Daten k&oumlnnen Sie sich wieder im System registrieren!');
                return $this->redirect()->toRoute('Hilfe');
            }
            else return $this->redirect()->toRoute('home');
        }
        return array('form' => $form,
            'Hilfe' => $Hilfe);
    }
    public function faqAction()
    {
        return array(             
        );
        
    }
    
    
    
    public function getHilfeMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('HilfeMapper');
    }

}