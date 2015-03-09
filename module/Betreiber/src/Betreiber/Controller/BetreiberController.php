<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Event for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Betreiber\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Betreiber\Model\BetreiberEntity;
use Betreiber\Form\BetreiberForm;
use Zend\Form\Element\Time;
use Zend\Form\Element\DateTimeLocal;
use Zend\Form\Element\DateTime;
use Zend\Filter\DateTimeFormatter;

class BetreiberController extends AbstractActionController
{
    
    // Index Betreiber
    public function indexAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        
        if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('search', array(
                'search' => 'index'
            ));
        }
        
        $mapper = $this->getBetreiberMapper();
        
        return new ViewModel(array(
            'betreiberliste' => $mapper->fetchAll()
        )
        );
    }
    
    // Mitarbeiter/Admin anzeigen
    public function showAction()
    {
        $id = $this->params('id');
        $betreiber = $this->getBetreiberMapper()->getBetreiber($id);
        if (! $betreiber) {
            return $this->redirect()->toRoute('betreiber');
        }
    }
    
    // Mitarbeiter/Admin hinzufügen
    public function addAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        
    if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('search', array(
                'search' => 'index'
            ));
        }
        if (isset($_REQUEST['email'])) {
            $email2 = $_REQUEST['email'];
            $name2 = $_REQUEST['name'];
            $vorname2 = $_REQUEST['vorname'];
            $passwort2 = $_REQUEST['passwort'];
            $rolle2 = $_REQUEST['rolle'];
            
            $id2 = $_REQUEST['id'];
            
            $check1 = $this->getBetreiberMapper()->checkEmailBetreiber($email2);
            $check2 = $this->getBetreiberMapper()->checkEmailLogindaten($email2);
            $check3 = $this->getBetreiberMapper()->checkID($id2);
            
            if ($check1 == NULL && $check2 == NULL && $check3 == NULL && strlen($passwort2) < 17 && strlen($passwort2) > 7 && $email2 != NULL && $name2 != NULL && $vorname2 != NULL && $passwort2 != NULL && $rolle2 != NULL) {
                
                $this->getBetreiberMapper()->Betreiberanlegen($id2, $email2, $name2, $vorname2, $passwort2, $rolle2);
                
                $this->flashMessenger()->addMessage('Betreiber erfolgreich angelegt!');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('betreiber', array(
                    'action' => 'index'
                ));
            } else {
                
                $this->flashMessenger()->addMessage('Stellen Sie sicher dass alle Textfelder korrekt bef&uuml;llt wurden und dass die Emailadresse oder die ID des Betreibers noch nicht bestehen!');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('betreiber', array(
                    'action' => 'add'
                ));
            }
        }
    }
    
    // Mitarbeiter/Admin bearbeiten
    public function editAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        
    if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('search', array(
                'search' => 'index'
            ));
        }
        $email = $this->params('email');
        
        $betreiber = $this->getBetreiberMapper()->getBetreiber($email);
        
        if (isset($_REQUEST['email']) && $_REQUEST['ID']) {
            
            $name2 = $_REQUEST['name'];
            $vorname2 = $_REQUEST['vorname'];
            $rolle2 = $_REQUEST['rolle'];
            $email2 = $_REQUEST['email'];
            $passwort2 = $_REQUEST['passwort'];
            $id2 = $_REQUEST['ID'];
            
            $this->getBetreiberMapper()->updatebetreiber($id2, $email2, $name2, $vorname2, $passwort2, $rolle2);
            
            $this->flashMessenger()->addMessage('Speichern erfolgreich! Betreiber wurde bearbeitet.');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('betreiber', array(
                'betreiber' => 'index'
            ));
        } 

        else {
            
            $id = $betreiber->getID();
            
            $name = $betreiber->getName();
            $vorname = $betreiber->getVorname();
            $email = $betreiber->getEmail();
            $passwort = $this->getBetreiberMapper()->getPasswort($email);
        }
        
        return array(
            'email' => $email,
            'id' => $id,
            'passwort' => $passwort,
            'name' => $name,
            'vorname' => $vorname
        );
    }
    
    // Mitarbeiter/Admin löschen
    public function deleteAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        
        // $username=$this->getUsermapper()->getUserobject($user['Rolle'],$user['Name']);
        
        $emailadmin = $user['Name'];
        
    if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('search', array(
                'search' => 'index'
            ));
        }
        $email = $this->params('email');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                $email = $this->params('email');
                if ($email == $emailadmin) {
                    $this->flashMessenger()->addMessage('Es ist nicht m&oumlglich ihren eigenen Account zu l&oumlschen!');
                    return $this->redirect()->toRoute('betreiber', array(
                        'betreiber' => 'index'
                    ));
                } else {
                    // $this->getBetreiberMapper()->deleteBetreiberConstraints($betreiber);
                    $this->getBetreiberMapper()->deleteBetreiber($email);
                    $this->flashMessenger()->addMessage('Betreiber erfolgreich entfernt!');
                }
            }
            
            // Redirect to list of tasks
            return $this->redirect()->toRoute('betreiber', array(
                'betreiber' => 'index'
            ));
        }
        return array(
            'email' => $email
        );
    }

    public function searchAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        
    if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('search', array(
                'search' => 'index'
            ));
        }
        
        $betreiber = new BetreiberEntity();
        
        // die †bergabe von Werten funktioniert noch nicht
        
        $request = $this->getRequest();
        
        if (isset($_REQUEST['email']) || isset($_REQUEST['nachname'])) {
            $email2 = $_REQUEST['email'];
            
            $nachname2 = $_REQUEST['nachname'];
            
            $mapper = $this->getBetreiberMapper();
            return new ViewModel(array(
                'betreiberliste' => $mapper->searchBetreiber($email2, $nachname2)
            )
            );
        }
        
        return array(
            'betreiberliste' => NULL,
        );
    
    }            
            
    

//BetreiberMapper
    public function getBetreiberMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BetreiberMapper');
    }
   
    
}
