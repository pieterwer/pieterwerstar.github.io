<?php
namespace Bewertung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bewertung\Model\BewertungEntity;
use Bewertung\Form\BewertungForm;
use Ergebnis\Model\DurchschnittEntity;

/**
 * BewertungController
 *
 * @author
 *
 * @version
 *
 */
class BewertungController extends AbstractActionController
{

    protected $athletTable;
    
    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getBewertungMapper();
        return new ViewModel(array(
            'bewertungen' => $mapper->fetchAll()
        ));
    }

    public function showAction()
    {
        $verid = (int) $this->params('id');
        if (! $verid) {
            return $this->redirect()->toRoute('Bild');
        }
        $Bild = $this->getBildMapper()->getBild($verid);
        $veranstaltungen = $this->getVeranstaltungMapper()->Veranstaltungver($verid);
        if (! $veranstaltungen) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        // $event = $this->getEventMapper()->getEvent($id);
        // $date = date_create($event->getDatum());
        // $event->setDatum (date_format($date,'Y-m-d H:i'));
        
        return new ViewModel(array(
            'veranstaltung' => $veranstaltungen,
            'Bild' => $Bild
        )
        );
    }

    public function addAction()
    {
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('event');
        }
        if(($event = $this->getEventMapper()->getEvent($id))== null){
            return $this->redirect()->toRoute('home');
        }
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        // †berprŸfen ob der user auch ein Veranstalter ist
        if ($user['Rolle'] != "at") {
            $this->flashMessenger()->addMessage('Es duerfen nur Athleten Bewertungen abgeben');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'show', 'id' => $id));
        }
        // †berprŸfen ob es bereits eine Anmeldung gibt
        if (!$this->getErgebnisMapper()->getErgebnis($id, $athlet->id)) {
            $this->flashMessenger()->addMessage('Sie haben sich noch nicht fuer dieses Event angemeldet');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'show', 'id'=>$id));
        }
        
        // †berprŸfen ob es bereits eine Anmeldung gibt
        if ($event->getDatum()>= date('Y-m-d H:i:s')) {
            $this->flashMessenger()->addMessage('Es kann erst nach Beendigung des Events Bewertungen abgeben werden.');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'show', 'id'=>$id));
        }
        
        //†berprŸfen ob der Athlet bereits eine Bewertung abgegeben hat
        if($this->getBewertungMapper()->getExistBewertung($athlet->id, $id))
        {
            $this->flashMessenger()->addMessage('Sie haben bereits eine Bewertung fuer dieses Event abgegeben');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'show', 'id' => $id));
        }
        
        $form = new BewertungForm();
        $bewertung = new BewertungEntity();
        $bewertung->setEventid($id);
        $form->bind($bewertung);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $bewertung->setAthletid($athlet->id);
               
                
                $this->getBewertungMapper()->saveBewertung($bewertung);
                
                return $this->redirect()->toRoute('event', array(
                    'action' => 'show', 'id' => $bewertung->getEventid()
                ));
                
            }
        }
        
        return new ViewModel(array(
            'form' => $form , 'eventid' => $id
        ));
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('Bild', array(
                'action' => 'add'
            ));
        }
        $Bild = $this->getBildMapper()->getBild($id);
        
        $form = new BildForm();
        $form->bind($Bild);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getBildMapper()->saveBild($Bild);
                
                return $this->redirect()->toRoute('Bild');
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form
        );
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $Bild = $this->getBildMapper()->getBild($id);
        if (! $Bild) {
            return $this->redirect()->toRoute('Bild');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getBildMapper()->deleteBild($id);
                $this->getBildMapper()->deleteLogin($Bild);
            }
            
            return $this->redirect()->toRoute('Bild');
        }
        
        return array(
            'id' => $id,
            'Bild' => $Bild
        );
    }

    public function durchschnittAction()
    {
        $evid = (int) $this->params('id');
        if (! $evid) {
            return $this->redirect()->toRoute('event');
        }
        
        $event = $this->getEventMapper()->getEvent($evid);
        if (! $event) {
            return $this->redirect()->toRoute('event', array(
                'action' => 'show'
            ));
        }
        
        // Auslesen des Durchschnitts
        $avg = $this->getBewertungMapper()->getDurchschnitt($event->getId());
//         print_r($avg);
        
        $bewertungen = $this->getBewertungMapper()->Bewertungev($event->getId());
        if (! $bewertungen) {
            return $this->redirect()->toRoute('bewertung');
        }
        // Auslesen des VorgŠngerwertes
        $vorgaenger = $this->getBewertungMapper()->getDurchschnitt($event->getVorgaengerid());
        
        //Durchschnittsbewertung Ÿber die Jahre
        
        //zwischenspeichern der vorgŠngerid der aufrufenden veranstaltung
        $vorid = $event->getVorgaengerid();
        $events = array();
        while($vorid != Null)
        {
            $vertmp = $this->getEventMapper()->getEvent($vorid);
            if($vertmp == null){
                break;
            }
            $events [] = $vertmp;
            $vorid = $vertmp->getVorgaengerid();
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
        
        //Athleten"Mapper"
        $athlet = $this->getAthletTable();
        
        //Bewertungsmapper fŸr †bergabe
        $star = $this->getBewertungMapper();
        
        return new ViewModel(array(
            'bewertungen' => $bewertungen,
            'event' => $event,
            'avg' => $avg,
            'vorgaenger' => $vorgaenger,
            'past' => $past,
            'athlet' => $athlet,
            'star' => $star
        )
        );
    }

    public function getBewertungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BewertungMapper');
    }

    public function getAvgbewertungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AvgbewertungMapper');
    }
    
    // Sowas sollte man eigentlich nicht machen
    // Am besten den VeranstaltungsController einbinden und dann Ÿber diesen die Funktion aufrufen!
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

    public function getDurchschnittMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('DurchschnittMapper');
    }
    
    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }
    
    public function getErgebnisMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ErgebnisMapper');
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