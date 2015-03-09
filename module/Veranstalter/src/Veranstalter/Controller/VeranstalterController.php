<?php
namespace Veranstalter\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstalter\Model\VeranstalterEntity;
use Veranstalter\Form\VeranstalterForm;

/**
 * VeranstalterController
 *
 * @author
 *
 * @version
 *
 */
class VeranstalterController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
		// Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
        ->get('AuthService')
        ->getStorage()
        ->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        
        //†berprŸfen ob der user auch ein Veranstalter ist
        if( $user==null || in_array(array('SA','AD'), array($user['Rolle'])))
        {
            $this->flashMessenger()->addMessage('Sie sind nicht berechtigt');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('login');
        }
		
        $mapper = $this->getVeranstalterMapper();
        return new ViewModel(array(
            'veranstaltern' => $mapper->fetchAll()
        ));
    }
    
    public function showAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstalter');
        }
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($verid);
        $veranstaltungen = $this->getVeranstaltungMapper()->Veranstaltungver($verid);
        if (!$veranstaltungen) {
            return $this->redirect()->toRoute('veranstaltung');
        }
    
//         $event = $this->getEventMapper()->getEvent($id);
//         $date = date_create($event->getDatum());
//         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'veranstaltungen' => $veranstaltungen , 'veranstalter' => $veranstalter
            
        ));
    
    }
    
    public function addAction(){
        $form = new VeranstalterForm();
        $veranstalter = new VeranstalterEntity();
        
        $form->bind($veranstalter);
        // die †bergabe von Werten funktioniert noch nicht
        $request = $this->getRequest();
        //†berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $pw = $request->getPost('passwort');
                $this->getVeranstalterMapper()->saveLogin($veranstalter, md5($pw));
                $this->getVeranstalterMapper()->saveVeranstalter($veranstalter);
                
                    $this->flashMessenger()->addMessage('Sie haben sich erfolgreich als Veranstalter angemeldet. Ihre Anfrage wird nun bearbeitet');
        
                // Redirect to list of tasks
                return $this->redirect()->toRoute('login');
            }
        }
        
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstalter', array('action'=>'add'));
        }
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($id);
    
        $form = new VeranstalterForm();
        $form->bind($veranstalter);
    
    
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getVeranstalterMapper()->saveVeranstalter($veranstalter);
    
                return $this->redirect()->toRoute('veranstalter');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function profilAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstalter', array('action'=>'add'));
        }
        //Auslesen des Veranstalters
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($id);
        
        //Auslesen der Veranstaltungen des Veranstalters
        $veranstaltungen = $this->getVeranstaltungMapper()->Veranstaltungver($veranstalter->getId());
        if (!$veranstaltungen) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        //Auslesen der Veranstaltungen des Veranstalters fŸr die Berechnung des Durchschnitts
        $veranstaltungen2 = $this->getVeranstaltungMapper()->Veranstaltungver($veranstalter->getId());
        if (!$veranstaltungen2) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        $stern = array();
        //Schleife fŸr das Auslesen der Bewertungen
        foreach($veranstaltungen2 as $veranstaltung2)
        {    
            //Auslesen der Events fŸr die Durchschnittbewertung
            $events = $this->getEventMapper()->Eventver($veranstaltung2->getId());
            if (!$events) {
                return $this->redirect()->toRoute('event');
            }
            $bewertung = $this->getBewertungMapper()->getVeranstaltung($events);
            
            
            // Array mit Werten befŸllen
            array_push($stern, $bewertung);
        }    
                
        $mapper = $this->getBewertungMapper();
        
        return new ViewModel(array(
            'veranstaltungen' => $veranstaltungen , 'veranstalter' => $veranstalter, 'stern' => $stern
            , 'mapper' => $mapper
        
        ));
    
        
    }
    
    public function ownAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        var_dump($user);
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        
        //Einbindung erst wenn Startseite vorhanden
        /*
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt die Artikel aus dem Warenkorb einzusehen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        */


    
        return new ViewModel(array(
            'veranstalter' => $veranstalter
    
        ));
    
    
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($id);
        if (!$veranstalter) {
            return $this->redirect()->toRoute('veranstalter');
        }
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getVeranstalterMapper()->deleteVeranstalter($veranstalter);
//                 $this->getVeranstalterMapper()->deleteLogin($veranstalter);
            }
    
            return $this->redirect()->toRoute('veranstalter');
        }
    
        return array(
            'id' => $id,
            'veranstalter' => $veranstalter
        );
    }
    
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
    
    // Sowas sollte man eigentlich nicht machen
    //Am besten den VeranstaltungsController einbinden und dann Ÿber diesen die Funktion aufrufen!
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
    }
    
    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }
    
    public function getBewertungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BewertungMapper');
    }
    
    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }
}