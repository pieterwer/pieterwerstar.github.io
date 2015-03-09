<?php
namespace Vereineinsicht\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vereineinsicht\Model\VereineinsichtEntity;
use Vereineinsicht\Form\VereineinsichtForm;

/**
 * VereineinsichtController
 *
 * @author
 *
 * @version
 *
 */
class VereineinsichtController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // Rolle überprüfen
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('auth', array(
                'action' => 'index'
            ));
        }
        
        $mapper = $this->getVereineinsichtMapper();
        return new ViewModel(array(
            'vereine' => $mapper->fetchAll()
        ));
    }

    public function addAction()
    {
        
        // Rolle überprüfen
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('auth', array(
                'action' => 'index'
            ));
        }
        if (isset($_REQUEST['email'])) {
            
            $id2 = $_REQUEST['id'];
            $name2 = $_REQUEST['name'];
            $adminemail2 = $_REQUEST['adminemail'];
            $iban2 = $_REQUEST['iban'];
            $bic2 = $_REQUEST['bic'];
            $email2 = $_REQUEST['email'];
            $strasse2 = $_REQUEST['strasse'];
            $hausnummer2 = $_REQUEST['hausnummer'];
            $plz2 = $_REQUEST['plz'];
            $ort2 = $_REQUEST['ort'];
            $status2 = $_REQUEST['status'];
            $bankkontoinhaber2 = $_REQUEST['kontoinhaber'];
            $vereinsvertreter2 = $_REQUEST['vereinsvertreter'];
            $passwort2 = $_REQUEST['passwort'];
            
            
            
            $check1 = $this->getVereineinsichtMapper()->checkEmailVerein($email2);
            $check2 = $this->getVereineinsichtMapper()->checkEmailAdmin($adminemail2);
            $check3 = $this->getVereineinsichtMapper()->checkID($id2);

            $check4=is_numeric($hausnummer2);
            $check5=is_numeric($plz2);
            
            
            
            if ($check1 == NULL && $check2 == NULL && $check3 == NULL && $check4==TRUE && $check5==TRUE && strlen($passwort2)>7 && strlen($passwort2)<17) {
                
                $this->getVereineinsichtMapper()->Vereinanlegen($id2, $name2, $adminemail2, $iban2, $bic2, $email2, $strasse2, $hausnummer2, $plz2, $ort2, $status2, $bankkontoinhaber2, $vereinsvertreter2, $passwort2);
                
                return $this->redirect()->toRoute('vereineinsicht');
            } else {
                
                $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten!  &Uuml;berpr&uuml;fen sie ob  die ID, Email und Adminemail nicht bereits existieren!
                                                      Ein weiterer Fehler kann das falsche Eingeben von Formaten sein wie bspw. Hausnummer=test');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('vereineinsicht', array(
                    'action' => 'add'
                ));
            }
        }
    }

    public function editAction()
    {
        
        // Rolle überprüfen
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('auth', array(
                'action' => 'index'
            ));
        }
        

        $id = $this->params('id');
        
        $verein = $this->getVereineinsichtMapper()->getVerein($id);
        
        
       
        
        if (isset($_REQUEST['id'])) {
            
            $id2 = $_REQUEST['id'];
            $name2 = $_REQUEST['name'];
            $adminemail2 = $_REQUEST['adminemail'];
            $iban2 = $_REQUEST['iban'];
            $bic2 = $_REQUEST['bic'];
            $email2 = $_REQUEST['email'];
            $strasse2 = $_REQUEST['strasse'];
            $hausnummer2 = $_REQUEST['hausnummer'];
            $plz2 = $_REQUEST['plz'];
            $ort2 = $_REQUEST['ort'];
            $status2 = $_REQUEST['status'];
            $bankkontoinhaber2 = $_REQUEST['kontoinhaber'];
            $vereinsvertreter2 = $_REQUEST['vereinsvertreter'];
            //$passwort2 = $_REQUEST['passwort'];
            
            $check1 = $this->getVereineinsichtMapper()->checkEmailVerein($email2);
            $check2 = $this->getVereineinsichtMapper()->checkEmailAdmin($adminemail2);
            $check3 = $this->getVereineinsichtMapper()->checkID($id2);
            $check4=is_numeric($hausnummer2);
            $check5=is_numeric($plz2);
            
            if( $id2!=NULL &&$name2!=NULL &&$adminemail2!=NULL &&$iban2!=NULL &&$bic2!=NULL &&$strasse2!=NULL &&$hausnummer2!=NULL &&$plz2!=NULL &&$ort2!=NULL &&$ort2!=NULL &&$status2!=NULL &&$bankkontoinhaber2!=NULL &&$vereinsvertreter2!=NULL)
            {
                $this->getVereineinsichtMapper()->updateVerein($id2, $name2, $adminemail2, $iban2, $bic2, $email2, $strasse2, $hausnummer2, $plz2, $ort2, $status2, $bankkontoinhaber2, $vereinsvertreter2);
                $this->flashMessenger()->addMessage('Speichern war erfolgreich!');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('vereineinsicht', array(
                    'action' => 'index'
                ));
            }else{
                $this->flashMessenger()->addMessage('Speichern war nicht erfolgreich!Es wurden manche Eingaben nicht get&auml;tigt!');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('vereineinsicht', array(
                    'action' => 'index'
                ));
                
                
            }
            
               
          
            
        } else {
            
            $id1 = $verein->getId();
            $name1 = $verein->getName();
            $adminemail1 = $verein->getAdminemail();
            $iban1 = $verein->getIban();
            $bic1 = $verein->getBic();
            $email1 = $verein->getEmail();
            $strasse1 = $verein->getStrasse();
            $hausnummer1 = $verein->getHausnummer();
            $plz1 = $verein->getPostleitzahl();
            $ort1 = $verein->getOrt();
            $status1 = $verein->getStatus();
            $bankkontoinhaber1 = $verein->getBankkontoinhaber();
            $vereinsvertreter1 = $verein->getVereinsvertreter();
        }
        
        return array(
            'id' => $id1,
            'name' => $name1,
            'adminemail' => $adminemail1,
            'iban' => $iban1,
            'bic' => $bic1,
            'email' => $email1,
            'strasse' => $strasse1,
            'hausnummer' => $hausnummer1,
            'plz' => $plz1,
            'ort' => $ort1,
            'status' => $status1,
            'bankkontoinhaber' => $bankkontoinhaber1,
            'vereinsvertreter' => $vereinsvertreter1
        )
        ;
    }

    public function deleteAction()
    { // Rolle überprüfen
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        if ($user['Rolle'] != "SA" && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('auth', array(
                'action' => 'index'
            ));
        }
        $id = $this->params('id');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                $id = $this->params('id');
                
                $this->getVereineinsichtMapper()->deleteVerein($id);
                $this->flashMessenger()->addMessage('Entfernen war erfolgreich!');
                // Redirect to list of tasks
                
            }
            return $this->redirect()->toRoute('vereineinsicht');
        }
        return array(
            'id' => $id
        )
        ;
    }

    public function getVereineinsichtMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VereineinsichtMapper');
    }
    
  
    
   
}