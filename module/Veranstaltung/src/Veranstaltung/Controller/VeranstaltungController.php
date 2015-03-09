<?php
namespace Veranstaltung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstaltung\Model\VeranstaltungEntity;
use Veranstaltung\Form\VeranstaltungForm;

/**
 * VeranstaltungController
 *
 * @author
 *
 * @version
 *
 */
class VeranstaltungController extends AbstractActionController
{
    protected $athletTable;

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        
        if($user == null || $user['Rolle'] != 'be'){
            if($user['Rolle']=='ve'){
                return $this->redirect()->toRoute('veranstaltung', array('action' => 'myveranstaltung'));
            }
            return $this->redirect()->toRoute('search', array('action' => 'veranstaltung'));
        }
        
        //FŸr bild
        $bild = $this->getVeranstaltungMapper();
        
        $mapper = $this->getVeranstaltungMapper();
        return new ViewModel(array(
            'veranstaltungen' => $mapper->fetchAll(), 'bild' => $bild
        ));
    }
    public function athletshowAction(){ //eingefügt von TW Gruppe7 
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
       
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => ''));
        }
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
    
//         $event = $this->getEventMapper()->getEvent($id);
//         $date = date_create($event->getDatum());
//         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'events' => $events , 'veranstaltung' => $veranstaltung
            
        ));
    
    }
	public function showgemeldeteAction(){ //eingefügt von TW Gruppe7 
       $athletid = (int) $this->params()->fromRoute('id', 0);
	   $ergebnisse = $this->getErgebnisMapper()->getEventid($athletid);
        return new ViewModel(array(
            'ergebnisse' => $ergebnisse 
            
        ));
    
    }
    public function myveranstaltungAction()
    {

        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
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
        //FŸr bild
        $bild = $this->getVeranstaltungMapper();
    
        $mapper = $this->getVeranstaltungMapper();
        return new ViewModel(array(
            'veranstaltungen' => $mapper->myVeranstaltungen($veranstalter->getId()), 'bild' => $bild
        ));
    }
    
    public function showAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
       
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => 'show'));
        }
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
    
//         $event = $this->getEventMapper()->getEvent($id);
//         $date = date_create($event->getDatum());
//         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'events' => $events , 'veranstaltung' => $veranstaltung
            
        ));
    
    }
    
    public function publicAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
         
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => 'show'));
        }
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
        
        //€ndern des Status von 0 auf 1, damit die Veranstaltung šffentlich geschaltet ist
        $this->getVeranstaltungMapper()->getPublic($veranstaltung);
        
        //Veranstalter auslesen
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($veranstaltung->getVeranstalterid());
    
        return new ViewModel(array(
            'events' => $events , 'veranstaltung' => $veranstaltung, 'veranstalter' => $veranstalter
    
        ));
    
    }
    
    public function historyAction(){
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($id);
        
        $zuordnung = array(
            'vorgŠnger' =>  $veranstaltung->getVorgaengerid(),
        );
        
        $veranstaltungen = $this->getVeranstaltungMapper()->history($id);
        if (!$veranstaltungen) {
            return $this->redirect()->toRoute('veranstaltung');
        }
       // print_r($veranstaltung);
       // print_r($veranstaltung);
//         echo "<br>";
        //print_r($veranstaltungen);
//         echo $veranstaltung->getName();
        
    
        
        //echo $veranstaltung[name];
       // echo $veranstaltung[];
//         $event = $this->getEventMapper()->getEvent($id);
//         $date = date_create($event->getDatum());
//         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'veranstaltungen' => $veranstaltungen , 'veranstaltung' => $veranstaltung, 'zu' => $zuordnung
            
        ));
    
    }
    
    public function histAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        //lŠdt die veranstaltung anhand der id aus der datenbank
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        //prŸft ob veranstaltung geladen wurde
        if (!$veranstaltung) {
            //leitet den benutzer zur Ÿbersicht zurŸck falls die veranstaltung nicht gefunden werden konnte
            return $this->redirect()->toRoute('veranstalter', array('action' => 'show'));
        }
        //zwischenspeichern der vorgŠngerid der aufrufenden veranstaltung
        $vorid = $veranstaltung->getVorgaengerid();
        $veranstaltungen = array();
         
        //schleife lŠuft solange wie sich ein vorgŠnger finden lŠsst
        while($vorid != Null)
        {
            $veranstaltungen [] = $vertmp = $this->getVeranstaltungMapper()->getVeranstaltung($vorid);
            $vorid = $vertmp->getVorgaengerid();
        }
         
        return new ViewModel(array(
            'veranstaltung' => $veranstaltung, 'veranstaltungen' =>$veranstaltungen
             
        ));
    }
    
    public function addAction(){
        $form = new VeranstaltungForm();
        $veranstaltung = new VeranstaltungEntity();
        
        
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
        ->get('AuthService')
        ->getStorage()
        ->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt Veranstaltungen zu erstellen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('veranstaltung', array('action' => 'index'));
        }
        $veranstaltung->setVeranstalterid($veranstalter->getId());
        $form->bind($veranstaltung);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Setzen der Veranstaltung auf nicht šffentlich
                $veranstaltung->setStatus(0);
                
                $this->getVeranstaltungMapper()->saveVeranstaltung($veranstaltung);
                $this->flashMessenger()->addMessage('Veranstaltung '. $veranstaltung->getName() .' erfolgreich angelegt');
        
                // Redirect to list of tasks
                return $this->redirect()->toRoute('event', array(
    'action' => 'add', 'id' => $veranstaltung->getId()
));
            }
        }
        
        return array('form' => $form);
    }
    
    public function vorgaengerAction()
    {
        echo "VorgŠnger";
        $mapper = $this->getVeranstaltungMapper();
        return new ViewModel(array(
            'veranstaltungen' => $mapper->fetchAll()
        ));
    }
    
    public function rewriteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstaltung', array('action'=>'add'));
        }
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($id);
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
    
        $form = new VeranstaltungForm();
        $form->bind($veranstaltung);
    
        //echo $id; //von dieser ID wollen wir die History
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $tmp = $veranstaltung->getId();
                $veranstaltung->setId(NULL);    //wegen Autoincrement
                $veranstaltung->setVorgaengerid($tmp);
                $veranstaltung->setVeranstalterid($veranstalter->getId());
//                 echo "2.Abschnitt";
                $this->getVeranstaltungMapper()->saveVeranstaltung($veranstaltung);
                $this->flashMessenger()->addMessage('Veranstaltung '. $veranstaltung->getName() .' erfolgreich angelegt');
        
                // Redirect to list of tasks
//                 echo"Finale woho";
                return $this->redirect()->toRoute('veranstaltung', array(
                'action' => 'select', 'id' => $veranstaltung->getVorgaengerid()
            ));
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstaltung', array('action'=>'add'));
        }
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($id);
        if ($veranstaltung==null) {
            return $this->redirect()->toRoute('home');
        }
    
        $form = new VeranstaltungForm();
        $form->bind($veranstaltung);
    
        //echo $id; //von dieser ID wollen wir die History
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getVeranstaltungMapper()->saveVeranstaltung($veranstaltung);
                return $this->redirect()->toRoute('veranstaltung', array('action' => 'myveranstaltung'));
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
            'veranstaltung' => $veranstaltung
        );
    }
    public function selectAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
         
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => 'select'));
        }
        $check = $this->getEventMapper();
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
    
        //         $event = $this->getEventMapper()->getEvent($id);
        //         $date = date_create($event->getDatum());
        //         $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'events' => $events , 'veranstaltung' => $veranstaltung, 'check' => $check
    
        ));
    
    }
    
    public function profilAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('veranstaltung');
        }
         
        //Auslesen der Veranstaltung
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (!$veranstaltung) {
            return $this->redirect()->toRoute('veranstalter', array('action' => 'show'));
        }
        
        //Auslesen der Events fŸr die Durchschnittbewertung
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
        $bewertung = $this->getBewertungMapper()->getVeranstaltung($events);
        
        //Auslesen der Vorjahresbewertung
        if($veranstaltung->getVorgaengerid() != NULL)
        {    
            $events2 = $this->getEventMapper()->Eventver($veranstaltung->getVorgaengerid());
            if (!$events2) {
                return $this->redirect()->toRoute('event');
            }
            $vbewertung = $this->getBewertungMapper()->getVeranstaltung($events2);
        }
        else
        {
            $vbewertung = NULL;
        }
        
        //Auslesen der Events fŸr die †bergabe
        $events = $this->getEventMapper()->Eventver($veranstaltung->getId());
        if (!$events) {
            return $this->redirect()->toRoute('event');
        }
        
        //Bild fŸr die Sternebewertung holen
        $var = round($bewertung);
        $stern = $this->getBewertungMapper()->getSterne($var);
        $link = "../../pictures/";
        $link .= $stern;
        
        //Veranstalter auslesen
        $veranstalter = $this->getVeranstalterMapper()->getVeranstalter($veranstaltung->getVeranstalterid());
        
        //FŸr bild
        $bild = $this->getVeranstaltungMapper();
        
        //Holen der letzten 3 Bewertungen
        $array = $this->getBewertungMapper()->Bewertungveranstaltung($veranstaltung->getId());
        $i = 0;
        $bewertungen = array();
        while($i < 3 && $i < count($array))
        {
            $vertmp = $this->getBewertungMapper()->getBewertung($array[$i]['id']);
            if($vertmp == null){
                break;
            }
            $bewertungen [] = $vertmp;
            $i++;
        }
        
//         print_r($bewertungen);
        
        //Bewertungsmapper fŸr †bergabe
        $star = $this->getBewertungMapper();
        
        //Athleten"Mapper"
        $athlet = $this->getAthletTable();
        
        //VeranstalterMapper
        $get = $this->getEventMapper();
        
        
        return new ViewModel(array(
            'events' => $events , 'veranstaltung' => $veranstaltung, 'bewertung' => $bewertung, 'vbewertung' => $vbewertung
            , 'link' => $link, 'veranstalter' => $veranstalter, 'bild' => $bild, 'bewertungen' => $bewertungen, 'athlet' => $athlet, 'star' => $star
            ,'get' => $get
    
        ));
    
    }
    
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
    
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
    
    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }
    
    public function getAthletTable()
    {
        if (!$this->athletTable) {
            $sm = $this->getServiceLocator();
            $this->athletTable = $sm->get('Starmina\Model\AthletTable');
        }
        return $this->athletTable;
    }
}