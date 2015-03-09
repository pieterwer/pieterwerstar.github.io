<?php
namespace Vereinsadminaendern\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vereinsadminaendern\Model\VereinsadminaendernEntity;
use Vereinsadminaendern\Form\VereinsadminaendernForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
/**
 * VereinsadminaendernController
 *
 * @author
 *
 * @version
 *
 */
class VereinsadminaendernController extends AbstractActionController
{

    
    public function indexAction()
    {
        // Gibt alle unbest�tigen Vereinsadmins aus
        
    // Rolle �berpr�fen
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
        
        $mapper = $this->getVereinsadminaendernMapper();
        return new ViewModel(array(
            'vereinsadminaendern1' => $mapper->fetchAll()
        ));
    }
    
    public function searchAction(){
    
        // Sucht nach Admin
        
    // Rolle �berpr�fen
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
    
    
        
        
    
        if(isset($_REQUEST['vereinid'])){
            $vereinid2 = $_REQUEST['vereinid'];
            
    
    
    
            $mapper = $this->getVereinsadminaendernMapper();
            return new ViewModel(array(
                'vereinsadminaendern1' => $mapper->searchVerein($vereinid2)
    
            ));
        }
        // Auslesen der �bergebenen Suchparameter
    
    
        return array(
           
            'vereinsadminaendern1' => NULL,
        );
    
    }
    
    
    
    
    public function updateAction(){
        // Legt neuen Vereinsadmin an
        
        
        
    // Rolle �berpr�fen
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
        //Ver�ndert bzw setzt einen neuen Vereinsadmin
        $id =$this->params('id');
        
        $form = new VereinsadminaendernForm();
        $vereinsadminaendern = new VereinsadminaendernEntity();
        
        $form->bind($vereinsadminaendern);
        // die �bergabe von Werten funktioniert noch nicht
        if(isset($_REQUEST['vereinid'])){
            
            
            $vereinid = $_REQUEST['vereinid'];
            $adminemail = $_REQUEST['adminemail'];
            $passwort = $_REQUEST['passwort'];
            
            // Hier fehlen noch die InputFilter Abfragen !!
           
     
                //�berpr�fung ob die VereinsID existiert
                $check1=$this->getVereinsadminaendernMapper()->checkid($vereinid);
                //�berpr�fung ob die eingegebene Email bereits existiert
                $check2=$this->getVereinsadminaendernMapper()->checkemaillogin($adminemail);
                
                $check3=is_numeric($vereinid);
                
                $check4=strlen($passwort);
                
            
                if ( $check1!=NULL && $check2==NULL && $check4<17 && $check4>7){
                
                    
                    //speichern des neuen Admins
                    $this->getVereinsadminaendernMapper()->saveLogin($adminemail,$passwort);
                    
                    $this->getVereinsadminaendernMapper()->saveVereinsadminaendern($adminemail,$vereinid);
                    
      
                    $this->flashMessenger()->addMessage('Neuer Vereinsadministrator erfolgreich angelegt');
                    // Redirect to list of tasks
                    
                    return $this->redirect()->toRoute('vereinsadminaendern', array('action' => 'index'));
                    
                   
                     
                } else {
                
           
                    $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten! Eventuell existiert diese Email bereits.
                        Achten sie zudem darauf, dass das Passwort zwischen 8 und 16 Zeichen lang sein muss!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('vereinsadminaendern', array('action' => 'index'));
                
            } 
            
            

                
   
                
        }
            
            
            
        return array('form' => $form,
                     'id'=>$id
        );
    }

    

    
    public function getVereinsadminaendernMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VereinsadminaendernMapper');
    }
}