<?php
namespace Athleteinsicht\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Athleteinsicht\Model\AthleteinsichtEntity;
use Athleteinsicht\Form\AthleteinsichtForm;

/**
 * VeranstalterController
 *
 * @author
 *
 * @version
 *
 */
class AthleteinsichtController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getAthleteinsichtMapper();
        return new ViewModel(array(
            'athleten' => $mapper->fetchAll()
        ));
    }
    
    
    
    public function zuordnungAction()
    {
        $id =$this->params('id');
    
        $mapper = $this->getAthleteinsichtMapper();
    
        $content2=$mapper->fetchAllZuordnung($id);
        
    
        return array(
            'inhalte'=>$content2,
            
            'id'=>$id,
        );
    }
    
    
    
    
    
        public function addAction(){
            
            

            if(isset($_REQUEST['email'])){
                
                
                $id2 = $_REQUEST['id'];
                $name2 = $_REQUEST['name'];
                $vorname2 = $_REQUEST['vorname'];
                $titel2 = $_REQUEST['titel'];
                $zusatz2 = $_REQUEST['zusatz'];
                $geburtstag2 = $_REQUEST['geburtstag'];
                $geschlecht2 = $_REQUEST['geschlecht'];
                $telefonnummer12 = $_REQUEST['telefonnummer1'];
                $telefonnummer22 = $_REQUEST['telefonnummer2'];
                $telefonnummer32 = $_REQUEST['telefonnummer3'];
                $fax2 = $_REQUEST['fax'];
                $email2 = $_REQUEST['email'];
                $passwort2 = $_REQUEST['passwort'];
                $firma2 = $_REQUEST['firma'];
                $iban2 = $_REQUEST['iban'];
                $bic2 = $_REQUEST['bic'];
                $historie2= $_REQUEST['historie'];
                $umkreis2 = $_REQUEST['umkreis'];
                $werbung2 = $_REQUEST['werbung'];
                $status2 = $_REQUEST['status'];
                
                $check1=$this->getAthleteinsichtMapper()->checkEmailAthlet($email2);
                $check2=$this->getAthleteinsichtMapper()->checkEmailLogindaten($email2);
                $check3=$this->getAthleteinsichtMapper()->checkId($id2);
                
                $check4=is_numeric($status2);
                $check5=is_numeric($umkreis2);
                $check6=is_numeric($werbung2);
                $check7=is_numeric($historie2);
                $check8=is_numeric($telefonnummer12);
                
                
                if($check1==NULL && $check2==NULL && $check3==NULL && $check4==TRUE && $check5==TRUE && $check6==TRUE && $check7==TRUE && $check8==TRUE && strlen($passwort2)>7 && strlen($passwort2)<17){
                    $this->getAthleteinsichtMapper()->Athletanlegen($id2,$name2,$vorname2,$titel2,$zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$passwort2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2);
                    
                    return $this->redirect()->toRoute('athleteinsicht');
                } 
                else {
                   $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten,vergewissern sie sich dass alle Eingaben korrekt betätigt wurden!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('athleteinsicht', array('action' => 'add'));
                }
                
                
            
            
            }
    }
    
    
public function editAction()
    {
        $id =$this->params('id');
        
        
        
        $athlet=$this->getAthleteinsichtMapper()->getAthlet($id);
        
        
        if(isset($_REQUEST['email'])){
            
                $id2 = $_REQUEST['id'];
                $name2 = $_REQUEST['name'];
                $vorname2 = $_REQUEST['vorname'];
                $titel2 = $_REQUEST['titel'];
                $Zusatz2 = $_REQUEST['zusatz'];
                $geburtstag2 = $_REQUEST['geburtstag'];
                $geschlecht2 = $_REQUEST['geschlecht'];
                $telefonnummer12 = $_REQUEST['telefonnummer1'];
                $telefonnummer22= $_REQUEST['telefonnummer2'];
                $telefonnummer32 = $_REQUEST['telefonnummer3'];
                $fax2 = $_REQUEST['fax'];
                $email2 = $_REQUEST['email'];
                $firma2 = $_REQUEST['firma'];
                $iban2 = $_REQUEST['iban'];
                $bic2 = $_REQUEST['bic'];
                $historie2 = $_REQUEST['historie'];
                $umkreis2 = $_REQUEST['umkreis'];
                $werbung2 = $_REQUEST['werbung'];
                $status2 = $_REQUEST['status'];
               // $passwort2 = $_REQUEST['passwort'];
            
                $check1=$this->getAthleteinsichtMapper()->checkEmailAthlet($email2);
                $check2=$this->getAthleteinsichtMapper()->checkEmailLogindaten($email2);
                $check3=$this->getAthleteinsichtMapper()->checkId($id2);
                
                $check4=is_numeric($status2);
                $check5=is_numeric($umkreis2);
                $check6=is_numeric($werbung2);
                $check7=is_numeric($historie2);
                $check8=is_numeric($telefonnummer12);
                //&& $status2!=NULL && $status2!=NULL && $status2!=NULL   && $check4!=True && $check5!=True && $check6!=True && $check7!=True && $check8!=True
                //if($id2!=NULL && $name2!=NULL && $vorname2!=NULL && $geburtstag2!=NULL && $geschlecht2!=NULL && $telefonnummer12!=NULL && $email2!=NULL && $iban2!=NULL && $bic2!=NULL && $historie2!=NULL && $umkreis2!=NULL && $werbung2!=NULL && $status2!=NULL){
                    $this->getAthleteinsichtMapper()->updateAthlet($id2,$name2,$vorname2,$titel2,$Zusatz2,$geburtstag2,$geschlecht2,$telefonnummer12,$telefonnummer22,$telefonnummer32,$fax2,$email2,$firma2,$iban2,$bic2,$historie2,$umkreis2,$werbung2,$status2);
                    $this->flashMessenger()->addMessage('Speichern war erfolgreich!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('athleteinsicht', array('action' => 'index'));
                //}
                
                    $this->flashMessenger()->addMessage('Es ist ein Fehler aufgetreten,vergewissern sie sich dass alle Eingaben korrekt sind!');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('athleteinsicht', array('action' => 'edit'));
                
                
            
        } 
         elseif(!isset($_REQUEST['email'])){
            
            
                $id1=$athlet->getId();
                $name1 = $athlet->getName();
                $vorname1 = $athlet->getVorname();
                $titel1 = $athlet->getTitel();
                $zusatz1 = $athlet->getZusatz();
                $geburtstag1 = $athlet->getGeburtstag();
                $geschlecht1 = $athlet->getGeschlecht();
                $telefonnummer1= $athlet->getTelefonnummer1();
                $telefonnummer2= $athlet->getTelefonnummer2();
                $telefonnummer3= $athlet->getTelefonnummer3();
                $fax1 = $athlet->getFax();
                $email1 = $athlet->getEmail();
                $firma1 = $athlet->getFirma();
                $iban1 = $athlet->getIban();
                $bic1 = $athlet->getBic();
                $historie1 = $athlet->getHistorie();
                $umkreis1 = $athlet->getUmkreis();
                $werbung1 = $athlet->getWerbung();
                $status1 = $athlet->getStatus();
            
           
        }
        

        return array(
            'id' => $id1,
            'name'=>$name1,
            'vorname'=>$vorname1,
            'titel'=>$titel1,
            'zusatz'=>$zusatz1,
            'geburtstag'=>$geburtstag1,
            'geschlecht'=>$geschlecht1,
            'telefonnummer1'=>$telefonnummer1,
            'telefonnummer2'=>$telefonnummer2,
            'telefonnummer3'=>$telefonnummer3,
            'fax'=>$fax1,
            'email'=>$email1,
            'firma'=>$firma1,
            'iban'=>$iban1,
            'bic'=>$bic1,
            'historie'=>$historie1,
            'umkreis'=>$umkreis1,
            'werbung'=>$werbung1,
            'status'=>$status1,
            
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
    
    public function deleteAction()
    {
         $id = $this->params('id');
         $email = $this->params('email');
         
         
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
                $id = $this->params('id');
                 $email = $this->params('email');
                $this->getAthleteinsichtMapper()->deleteAthlet($id,$email);
            }
            return $this->redirect()->toRoute('athleteinsicht');
        }
        return array(
            'id' => $id,
            'email'=>$email
            
        );
    }
    
public function getAthleteinsichtMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AthleteinsichtMapper');
    }
    
    
}