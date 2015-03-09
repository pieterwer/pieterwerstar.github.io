<?php
namespace Werbeauftrag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Werbeauftrag\Model\WerbeauftragEntity;
use Werbeauftrag\Form\WerbeauftragForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\InputFilter\Factory;

/**
 * WerbeauftragController
 *
 * @author
 *
 * @version
 *
 */
class WerbeauftragController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
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
        $mapper = $this->getWerbeauftragMapper();
        return new ViewModel(array(
            'werbeauftrage' => $mapper->fetchAll()
        ));
    }

    public function zuordnungAction()
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
        
        $mapper = $this->getWerbeauftragMapper();
        
        $content2 = $mapper->fetchAllZuordnung($id);
        $content3 = $mapper->fetchAllZuordnungVeranstalter($id);
        
        return array(
            'inhalte' => $content2,
            'inhalte2' => $content3,
            'id' => $id
        );
    }

    public function werbeauftragveranstalterzuordnungAction()
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
        
        $form = new WerbeauftragForm();
        $werbeauftrag = new WerbeauftragEntity();
        
        $form->bind($werbeauftrag);
        
        $request = $this->getRequest();
        
        $mapper = $this->getWerbeauftragMapper();
        
        // Auslesen der übergebenen Suchparameter
        if (isset($_REQUEST['werbeauftragid'])) {
            
            $werbeauftragid2 = $_REQUEST['werbeauftragid'];
            $veranstalterid2 = $_REQUEST['veranstalterid'];
            
            $check1 = $mapper->checkwerbeauftragid($werbeauftragid2);
            $check2 = $mapper->checkveranstalterid($veranstalterid2);
            $check3 = $mapper->checkEintragZuordnungVeranstalter($werbeauftragid2, $veranstalterid2);
            
            if ($werbeauftragid2 != NULL || $veranstalterid2 != NULL) {
                
                // Check ob es bereits einen Eintrag gibt und ob die Angegebenen IDs existieren
                if ($check1 != NULL && $check2 != NULL && $check3 == NULL) {
                    
                    $mapper = $this->getWerbeauftragMapper();
                    $mapper->createZuweisungWerbeauftragVeranstalter($werbeauftragid2, $veranstalterid2);
                     $this->flashMessenger()->addMessage('Zuweisung erfolgreich angelegt!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('werbeauftrag', array(
                        'action' => 'index'
                    ));
                } else {
                    
                    $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten, versichern sie sich, dass Werbe- &VeranstalterID richtig sind und die Zuordnung noch nicht besteht!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('werbeauftrag', array(
                        'action' => 'index'
                    ));
                }
            }
        }
        
        return array(
            'form' => $form
        );
    }

    public function werbeauftragathletenzuordnungAction()
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
        
        $form = new WerbeauftragForm();
        $werbeauftrag = new WerbeauftragEntity();
        
        $form->bind($werbeauftrag);
        // die †bergabe von Werten funktioniert noch nicht
        
        $request = $this->getRequest();
        
        if (isset($_REQUEST['werbeauftragid'])) {
            $werbeauftragid2 = $_REQUEST['werbeauftragid'];
            $athletid2 = $_REQUEST['athletid'];
            
            $mapper = $this->getWerbeauftragMapper();
            $check1 = $mapper->checkwerbeauftragid($werbeauftragid2);
            $check2 = $mapper->checkathletid($athletid2);
            $check3 = $mapper->checkEintragZuordnungAthleten($werbeauftragid2, $athletid2);
            
            if ($werbeauftragid2 != NULL || $athletid2 != NULL) {
                
                if ($check1 != NULL && $check2 != NULL && $check3 == NULL) {
                    
                    $mapper->createZuweisungWerbeauftragathlet($werbeauftragid2, $athletid2);
                    $this->flashMessenger()->addMessage('Zuweisung erfolgreich angelegt!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('werbeauftrag', array(
                        'action' => 'index'
                    ));
                } else {
                    
                    $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten, versichern sie sich, dass Werbe- &AthletID richtig sind und die Zuordnung noch nicht besteht');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('werbeauftrag', array(
                        'action' => 'werbeauftragathletenzuordnung'
                    ));
                }
            }
        }
        
        return array(
            'form' => $form
        );
    }

    public function searchAction()
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
        
        $form = new WerbeauftragForm();
        $werbeauftrag = new WerbeauftragEntity();
        
        $form->bind($werbeauftrag);
        // die †bergabe von Werten funktioniert noch nicht
        
        $request = $this->getRequest();
        
        if (isset($_REQUEST['id'])) {
            $id2 = $_REQUEST['id'];
            $name2 = $_REQUEST['name'];
            
            $mapper = $this->getWerbeauftragMapper();
            return new ViewModel(array(
                'werbeauftrage' => $mapper->searchWerbeauftrag($id2, $name2)
            ));
        }
        // Auslesen der übergebenen Suchparameter
        
        return array(
            'form' => $form,
            'werbeauftrage' => NULL
        );
    }

    public function addAction()
    {
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        if (($user['Rolle'] != "SA") && ($user['Rolle'] != "AD")) {
            $this->flashMessenger()->addMessage('Dieser Vorgang ist nur Administratoren vorbehalten!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('auth', array(
                'action' => 'index'
            ));
        }
        
        $form = new WerbeauftragForm();
        $werbeauftrag = new WerbeauftragEntity();
        
        $form->bind($werbeauftrag);
        // die †bergabe von Werten funktioniert noch nicht
        
        // Inputs überprüfen mit Inputfilter
        if (isset($_REQUEST['name'])) {
            
            $name = $this->params('name');
            $werbeauftrag->setName($name);
            
            $request = $this->getRequest();
            // †berprŸft ob etwas vorhanden ist
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    
                    $check1 = $this->getWerbeauftragMapper()->checkname($werbeauftrag->getName());
                    
                    // Wenn der Name noch nicht vorhanden ist dann...
                    if ($check1 == NULL) {
                        
                        // Werbeauftrag wird eingespeichert
                        $this->getWerbeauftragMapper()->saveWerbeauftrag($werbeauftrag);
                        $this->flashMessenger()->addMessage('Werbeauftrag erfolgreich angelegt!');
                        // Redirect to list of tasks
                        return $this->redirect()->toRoute('werbeauftrag');
                    } else {
                        
                        $this->flashMessenger()->addMessage('Werbeauftrag existiert bereits!');
                        // Redirect to list of tasks
                        return $this->redirect()->toRoute('werbeauftrag', array(
                            'action' => 'add'
                        ));
                    }
                }
            }
        }
        
        return array(
            'form' => $form,
            'msg' => NULL
        );
    }

    public function editAction()
    {
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
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('werbeauftrag', array(
                'action' => 'add'
            ));
        }
        $werbeauftrag = $this->getWerbeauftragMapper()->getWerbeauftrag($id);
        
        $form = new WerbeauftragForm();
        $form->bind($werbeauftrag);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $check1 = $this->getWerbeauftragMapper()->checkname($werbeauftrag->getName());
                if ($check1 == NULL) {
                    $this->getWerbeauftragMapper()->updateWerbeauftrag($werbeauftrag);
                    $this->flashMessenger()->addMessage('Werbeauftrag erfolgreich gespeichert!');
                    return $this->redirect()->toRoute('werbeauftrag');
                } else {
                    $this->flashMessenger()->addMessage('Werbeauftrag existiert bereits!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('werbeauftrag', array(
                        'action' => 'index'
                    ));
                }
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form
        );
    }

    public function deleteAction()
    {
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
        $werbeauftrag = $this->getWerbeauftragMapper()->getWerbeauftrag($id);
        if (! $werbeauftrag) {
            return $this->redirect()->toRoute('werbeauftrag');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                
                $this->getWerbeauftragMapper()->deleteWerbeauftrag($id);
                $this->flashMessenger()->addMessage('L&oumlschen war erfolgreich!');
                // Redirect to list of tasks
                return $this->redirect()->toRoute('werbeauftrag', array(
                    'action' => 'index'
                ));
            }
            
            return $this->redirect()->toRoute('werbeauftrag');
        }
        
        return array(
            'id' => $id,
            'werbeauftrag' => $werbeauftrag
        );
    }
    
    
    
    public function getWerbeauftragMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('WerbeauftragMapper');
    }
}