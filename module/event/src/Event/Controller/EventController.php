<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Event for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Event\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Event\Model\EventEntity;
use Event\Form\EventForm;
use Zend\Form\Element\Time;
use Zend\Form\Element\DateTimeLocal;
use Zend\Form\Element\DateTime;
use Zend\Filter\DateTimeFormatter;
//Zum Anzeigen der Ergebnisliste
use Ergebnis\Model\ErgebnisEntity;
use Ergebnis\Form\ErgebnisForm;
use Event\Form\LabelForm;

class EventController extends AbstractActionController
{

    protected $athletTable;
    
    public function indexAction()
    {
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        
        if($user == null || $user['Rolle'] != 'SA'){
            if($user['Rolle']=='ve'){
                return $this->redirect()->toRoute('event', array('action' => 'myevent'));
            }
            return $this->redirect()->toRoute('search', array('action' => 'index'));
        }
        //FŸr bild
        $bild = $this->getEventMapper();
        
        $mapper = $this->getEventMapper();
        $eventid = 1;
        $sportartid = 2;
        return new ViewModel(array(
            'events' => $mapper->fetchAll(),
            'bild' => $bild
        ));
    }
    
    public function myeventAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
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
        $bild = $this->getEventMapper();
//         echo "Vid:";
//         Echo $veranstalter->getId();
    
        $mapper = $this->getEventMapper();
//         $eventid = 1;
//         $sportartid = 2;
//         $zuordnung = array(
//             'eventid' => $eventid,
//             'sportartid' => $sportartid
//         );
        return new ViewModel(array(
            'events' => $mapper->myevents($veranstalter->getId()),
            'bild' => $bild
        ));
    }
    
    public function kinderAction()
    {
        //FŸr bild
        $bild = $this->getEventMapper();
    
        $mapper = $this->getEventMapper();
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
        
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
        ->get('AuthService')
        ->getStorage()
        ->read();
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        
        if($user['Rolle'] != "at")
        {
            $this->flashMessenger()->addMessage('Nur Athlet ist es erlaubt diese Ansicht zu sehen!');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('kinder', array('action' => 'index'));
        }

        
        return new ViewModel(array(
            'events' => $mapper->fetchAllkind(),
            'bild' => $bild,
            'form' => $form,
            'athlet' => $athlet
        ));
    }
    public function showAction()
    {
        //Auslesen der fŸr das Event wichtigen Daten
        $id = $this->params('id');
        $event = $this->getEventMapper()->getEvent($id);
        if (! $event) {
            return $this->redirect()->toRoute('event');
        }
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
        
        $event = $this->getEventMapper()->getEvent($id);
        $date = date_create($event->getDatum());
        $event->setDatum(date_format($date, 'Y-m-d H:i'));
        
        //Auslesen der Durchschnittsbewertung 
        $avg = $this->getBewertungMapper()->getDurchschnitt($event->getId());
//         print_r($avg);
        
        //Auslesen des VorgŠngerwertes
        $vorgaenger = $this->getBewertungMapper()->getDurchschnitt($event->getVorgaengerid());
//         print_r($vorgaenger);
        
        //Bild fŸr die Sternebewertung holen
        $var = round($avg);
        $stern = $this->getBewertungMapper()->getSterne($var);
        $link = "../../pictures/";
        $link .= $stern;

        //†berprŸfen ob der angemeldete Benutzer fŸr das betrachtete Event schon angemeldet ist
            //Ausgabe des angelegten Users
            $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//             var_dump($user);

            if($user['Rolle']  == 'at')
            {
                error_reporting(0);
                $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
                error_reporting(E_ALL);
                //†berprŸfen ob es bereits eine Anmeldung gibt
                if($this->getErgebnisMapper()->getErgebnis($event->getId(), $athlet->id))
                {
                    $x = 1;
                }
                else
                {
                    $x = 0;
                }
            }
            else 
            {
                $x = 4;
            }
        //†berprufen ob es schon eine abgelaufene Veranstaltung ist
        $timestamp = time();
        $zeit = date("Y-m-d H:i", $timestamp);
//         echo "<br>";
//         echo $zeit;
//         echo"<br>";
//         echo $event->getDatum();
        if($zeit>=$event->getDatum())
        {
            $x = 2;
        }
        
        //FŸr bild
        $bild = $this->getEventMapper();
        
        //Holen der letzten 3 Bewertungen
        $bewertungen = $this->getBewertungMapper()->Bewertungprofil($event->getId());
        if (! $bewertungen) {
            return $this->redirect()->toRoute('bewertung');
        }
        //Bewertungsmapper fŸr †bergabe
        $star = $this->getBewertungMapper();
        
        //Athleten"Mapper"
        $athlet = $this->getAthletTable();
        
        //Durchschnittsbewertung Ÿber die Jahre
        
        //zwischenspeichern der vorgŠngerid der aufrufenden veranstaltung
        $vorid = $event->getVorgaengerid();
        $events = array();
        while($vorid != Null)
        {
            $vertmp = $this->getEventMapper()->getEvent($vorid);
            if($vertmp != null){
            $events [] = $vertmp;
            $vorid = $vertmp->getVorgaengerid();
            } else {
                $vorid = null;
            }
        }
        $summe = 0;
        $i = 0;
        foreach($events as $e)
        {
            $neu = $this->getBewertungMapper()->getDurchschnitt($e->getId());
            $summe += $neu;
            $i++;
        }
        if($i > 0)
        {
            $past = round($summe/ $i, 2);
        }
        else 
        {
            $past = NULL;
        }
            
        return new ViewModel(array(
            'event' => $event,  'avg' => $avg, 'vorgaenger' => $vorgaenger, 'link' => $link,
            'x' => $x, 'bild' => $bild, 'labels' => $this->getEventlabelMapper()->getLabels($event->getId())
            ,'bewertungen' => $bewertungen, 'athlet' => $athlet, 'star' => $star, 'form' => $form
            ,'past' => $past
        ));
    }

    public function showdetailAction()
    {
        $id = $this->params('id');
        $event = $this->getEventMapper()->getEvent($id);
        if (! $event) {
            return $this->redirect()->toRoute('event');
        }
        
        $date = date_create($event->getDatum());
        $event->setDatum(date_format($date, 'Y-m-d H:i'));
        $verid = $event->getVeranstaltungsid();
        $kategorien = $this->getEventkategorieMapper()->getKategorienbezeichnung($event->getId());
        
        return new ViewModel(array(
            'event' => $event,'kategorien' => $kategorien
        ));
    }

    public function addAction()
    {
        $verid = $this->params('id');
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($verid);
        if (! $veranstaltung) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        // if (!$verid) {
        // return $this->redirect()->toRoute('veranstaltung');
        // }
        $event = new EventEntity();
        if ($verid != Null)
            $event->setVeranstaltungsid($verid);
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
        $event->setDatum(date('Y-m-d H:i'));
        $form->bind($event);
        
        $request = $this->getRequest();
        if ($request->getPost('veranstaltungsid') == NULL) {
            $event->setVeranstaltungsid($verid);
        }
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $datum = $request->getPost('Date').' '.$request->getPost('Time');
            
            if ($form->isValid()) {
                $event->setDatum($datum);
                $event->setStatus($veranstaltung->getStatus());
                $this->getEventMapper()->saveEvent($event);
                $this->getEventsportartMapper()->saveEventzu($event->getId(), $request->getPost('sportart'));
                if(($kategorien = $request->getPost('kategorien'))!=Null)
                {
                    $this->getEventkategorieMapper()->deleteEvent($event->getId());
                        $this->getEventkategorieMapper()->saveEventzu($event->getId(), $kategorien);
                }
//                 Redirect zu Strecke anlegen
                return $this->redirect()->toRoute('strecke', array(
                    'action' => 'add',
                    'id' => $event->getId()
                ));
            }
        }
//         if($verid == Null){
//             $verid = $event->getVeranstaltungsid();
//         };
        return array(
            'form' => $form,
            'request' => $request,
            'kategorien' => $request->getPost('kategorien'),
            'test' => $request->getPost('sportart'),
            'verid' => $event->getVeranstaltungsid()
        );
    }

    public function editAction()
    {
    $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('event', array(
                'action' => 'add'
            ));
        }
        $event = $this->getEventMapper()->getEvent($id);
        // $date = date_create($event->getDatum());
        // $event->setDatum(date_format($date, 'Y-m-d H:i'));
        if ($event == null) {
            return $this->redirect()->toRoute('login');
        }
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        // var_dump($user);
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        
        // Einbindung erst wenn Startseite vorhanden
        
        // †berprŸfen ob der user auch ein Veranstalter oder Betreiber ist
        if ($user == null || ! in_array($user['Rolle'], array(
            've',
            'SA'
        ))) {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt ihre Veranstaltung zu bearbeiten');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('login');
        }
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($event->getVeranstaltungsid());
        if ($user['Rolle'] != 'SA') {
            if ($veranstaltung == null || $veranstaltung->getVeranstalterid() != $veranstalter->getId()) {
                $this->flashMessenger()->addMessage('Sie dürfen nur ihre Eigenen Events bearbeiten.');
                
                return $this->redirect()->toRoute('login');
            }
            if($event->getDatum()<=date('Y-m-d h:i:s')){
                $this->flashMessenger()->addMessage('Diese Events ist bereits abgeschlossen.');
                
                return $this->redirect()->toRoute('login');
            }
            
            if($this->getErgebnisMapper()->Ergebnisev($event->getId())->count()!= 0){
                $this->flashMessenger()->addMessage('Es haben sich bereits Athleten für das Event angemeldet.');
            
                return $this->redirect()->toRoute('login');
            }
        }
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
//         $event->getKategorien;
//         $event->setKategorien(NULL);
        $form->bind($event);
        $form->setData(array('Time' => date_format(date_create($event->getDatum()),'H:i'),
        'Date' => date_format(date_create($event->getDatum()),'Y-m-d') ));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $datum = $request->getPost('Date').' '.$request->getPost('Time');
            if ($form->isValid()) {
                $event->setDatum($datum);
                $this->getEventsportartMapper()->saveEventzu($event->getId(), $request->getPost('sportart'));
                $this->getEventkategorieMapper()->saveEventzu($event->getId(), $request->getPost('kategorien'));
                $this->getEventMapper()->saveEvent($event);
//                 echo"Šndern funktioniert";
                return $this->redirect()->toRoute('veranstaltung', array(
                    'action' => 'show',
                    'id' => $event->getVeranstaltungsid()
                ));
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form,
            'event' => $event
        );
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $event = $this->getEventMapper()->getEvent($id);
        if (! $event) {
            return $this->redirect()->toRoute('event');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getEventMapper()->deleteEventConstraints($event);
                $this->getEventMapper()->deleteEvent($id);
            }
            
            return $this->redirect()->toRoute('event');
        }
        
        return array(
            'id' => $id,
            'event' => $event
        );
    }

    public function histAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('event');
        }
        //lŠdt das event anhand der id aus der datenbank
        $event = $this->getEventMapper()->getEvent($verid);
        //prŸft ob event geladen wurde
        if (!$event) {
            //leitet den benutzer zur Ÿbersicht zurŸck falls das event nicht gefunden werden konnte
            return $this->redirect()->toRoute('event', array('action' => 'show'));
        }
        //zwischenspeichern der vorgŠngerid der aufrufenden veranstaltung
        $vorid = $event->getVorgaengerid();
        $events = array();
         
        //schleife lŠuft solange wie sich ein vorgŠnger finden lŠsst
        while($vorid != Null)
        {
            $events [] = $vertmp = $this->getEventMapper()->getEvent($vorid);
            $vorid = $vertmp->getVorgaengerid();
        }
        print_r($events);
        return new ViewModel(array(
            'event' => $event, 'events' =>$events
             
        ));
    }
    
    public function rewriteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('event', array('action'=>'add'));
        }
        $event = $this->getEventMapper()->getEvent($id);
        $date = date_create($event->getDatum());
        $event->setDatum(date_format($date, 'Y-m-d H:i'));
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
        $form->setData(array('Time' => date_format(date_create($event->getDatum()),'H:i'),
            'Date' => date_format(date_create($event->getDatum()),'Y-m-d') ));
   
        $form->bind($event);
    
        //echo $id; //von dieser ID wollen wir die History
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $datum = $request->getPost('Date').' '.$request->getPost('Time');
            if ($form->isValid()) {
                $tmp = $event->getId();
                $event->setId(NULL);    //wegen Autoincrement
                $event->setVorgaengerid($tmp);
                $back=$event->getVeranstaltungsid();
                //hier wird die ID fŸr die Veranstaltung ausgelesen, damit nicht die vom VorgŠnger reingeschrieben wird
                $a = $this->getVeranstaltungMapper()->getVorlageid($event->getVeranstaltungsid());
                echo "2.Abschnitt";
                echo $a;
                $event->setVeranstaltungsid($a);
                $this->getEventMapper()->saveEvent($event);
                $this->getEventsportartMapper()->saveEventzu($event->getId(), $request->getPost('sportart'));
                $this->getEventkategorieMapper()->saveEventzu($event->getId(), $request->getPost('kategorien'));
                $this->flashMessenger()->addMessage('Event '. $event->getName() .' erfolgreich angelegt');
    
                // Redirect to list of tasks
                echo"Finale woho";
                return $this->redirect()->toRoute('veranstaltung', array(
                'action' => 'select', 'id' => $back));
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
 /*   
    public function ergebnisAction(){
        $verid = (int)$this->params('id');
        if (!$verid) {
            return $this->redirect()->toRoute('event');
        }
        //lŠdt das event anhand der id aus der datenbank
        $event = $this->getEventMapper()->getEvent($verid);
        //prŸft ob event geladen wurde
        if (!$event) {
            //leitet den benutzer zur Ÿbersicht zurŸck falls das event nicht gefunden werden konnte
            return $this->redirect()->toRoute('event', array('action' => 'show'));
        }
        //zwischenspeichern der vorgŠngerid der aufrufenden veranstaltung
        $eventid = $event->getId();
        // Anhand der ID werden jetzt die Ergebnisse fŸr diese Veranstaltung geladen
        $ergebnisse = array();

            $ergebnisse [] = $vertmp = $this->getErgebnisMapper()->getErgebnis($eventid);
   
         
        return new ViewModel(array(
            'event' => $event, 'events' =>$ergebnisse
             
        ));
    }
  */  
    
    public function aktuellAction()
    {
        $id = (int)$this->params('id');
        if($id != null && $this->getEventMapper()->getAktuell($id)->count() == Null ){
            return $this->redirect()->toRoute('event');
        }
        $mapper = $this->getEventMapper();
        $events = $mapper->getAktuell($id);
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new EventForm($dbAdapter);
        
        return new ViewModel(array(
            'events' => $events, 'form' => $form 
            
        ));
    }
    
    public function multiplikatorAction()
    {
        $mapper = $this->getEventMapper();
        $events = $mapper->getAktuell();
    
        return new ViewModel(array(
            'events' => $events
    
        ));
    }
    //label beantragen
    public function labelAction(){
        
        $eventid = (int)$this->params('id');
        
        if(($event = $this->getEventMapper()->getEvent($eventid))==Null){
        
            return $this->redirect()->toRoute('event');
        
        }
                
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        $form = new LabelForm($dbAdapter,$eventid);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $result = $this->getEventlabelMapper()->saveEventzu($eventid,$request->getPost('label'));
                return $this->redirect()->toRoute('event',array('action'=>'label','id' => $eventid));
            }
        }
        
        $sql       = 'SELECT * FROM label where id not in (select labelid from event_label_zuordnung where eventid = ?)';
        $statement = $dbAdapter->query($sql);
        $result    = $statement->execute(array($eventid));
        
        if(($check = $result->getAffectedRows())==Null){
        }
        
        return new ViewModel(array(
            'form' => $form, 'eventid' => $eventid, 'check' => $check,'Genehmigt' => $this->getEventlabelMapper()->getLabels($event->getId())
            ,'Beantragt' => $this->getEventlabelMapper()->getLabels($event->getId(), Null)
            ));
    }
    
    
    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }

    public function getErgebnisMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ErgebnisMapper');
    }
    

    public function getEventkategorieMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventkategorieMapper');
    }
    
    public function getEventsportartMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventsportartMapper');
    }
    
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
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
    
    public function getLabelMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LabelMapper');
    }
    
    public function getEventlabelMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventlabelMapper');
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
