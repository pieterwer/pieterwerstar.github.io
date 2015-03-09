<?php
namespace Athletenbezahlung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Athletenbezahlung\Model\AthletenbezahlungEntity;
use Athletenbezahlung\Form\AthletenbezahlungForm;
use Zend\Form\Element\Time;
use Zend\Form\Element\DateTimeLocal;
use Zend\Form\Element\DateTime;
use Zend\Filter\DateTimeFormatter;

/**
 * AthletenbezahlungController
 *
 * @author
 *
 * @version
 *
 */

class AthletenbezahlungController extends AbstractActionController
{
    
    /**
     * The default action - show the home page
     */
    public function indexAction()
    {   
        $mapper = $this->getAthletenbezahlungMapper();
        return new ViewModel(array(
            'athletenbezahlungen' => $mapper->fetchAll()
        ));
    }
    
    public function searchAction(){
        // Sucht nach gewissen Athletenbezahlungen
        $form = new AthletenbezahlungForm();
        $athletenbezahlung = new AthletenbezahlungEntity();
        $form->bind($athletenbezahlung);
        // die †bergabe von Werten funktioniert noch nicht
        
        
        if(isset($_REQUEST['id'])){
            
            $id2 = $_REQUEST['id'];
            $useid2 = $_REQUEST['useid'];
            $mapper = $this->getAthletenbezahlungMapper();
            return new ViewModel(array(
                'athletenbezahlungen' => $mapper->fetchAllindividuell($id2,$useid2)
            
            ));
            
        }    
            
        return array('form' => $form,
            'athletenbezahlungen' => NULL,
        );
        
    }
    
    
    
    public function groupAction()
    {
        // Gruppiert die Athletenbezahlung nach Verwendungszweck
        
        $mapper = $this->getAthletenbezahlungMapper();
        return new ViewModel(array(
            'athletenbezahlungen' => $mapper->fetchAllgroup()
        ));
    }
    
    
    public function showAction(){
      $id1 = $this->params('id');
     // $form = new WerbeauftragForm();
      
      echo $id1;
     
     // $athletenbezahlungen = $this->getAthletenbezahlungenMapper()->fetchAllindividuell($id1);
      //  if (!$athletenbezahlungen) {
       //     return $this->redirect()->toRoute('athletenbezahlungen');
       // }
    
       // return new ViewModel(array(
         //   'athletenbezahlungen' => $athletenbezahlungen
        //));
        
        $mapper = $this->getAthletenbezahlungMapper();
        return new ViewModel(array(
            'athletenbezahlungen' => $mapper->fetchAllindividuell($id1)
        ));
    
    }
    
    
    public function backAction(){
        // Überweist das geld zurück an den athleten
        $id1 = $this->params('id');
        $athletid1 = $this->params('athletid');
        $wert1 = $this->params('wert');
        $athletenbezahlung = $this->getAthletenbezahlungMapper()->getAthletenbezahlung($id1);
        $request = $this->getRequest();
        
        $check1=$this->getAthletenbezahlungMapper()->checkbuchungsid($id1);
        $check2=$this->getAthletenbezahlungMapper()->checkathletid($athletid1);
      
        
        if($check1!=NULL && $check2!=NULL){
            
            if ($request->isPost()) {
                if ($request->getPost()->get('del') == 'Ja') {
            
                    $this->getAthletenbezahlungMapper()->backtoAthlet($id1,$athletid1,$wert1);
            
                }
            
                return $this->redirect()->toRoute('athletenbezahlung');
            }
            
             
            return array(
                'id' => $id1,
                'athletid' => $athletid1,
                'wert' => $wert1,
                 
                'athletenbezahlung'=>$athletenbezahlung
                 
            );
        }
        
        
      
    }
    
    
    
    public function forwardAction(){
       // Überweist das Geld weiter an den Veranstalter    
      
        
        //Auslesen der parameter-> werden erfolgreich übergeben
       
        $id1 = $this->params('id');
        $athletid1 = $this->params('athletid');
        $wert1 = $this->params('wert');
        $useid1 = $this->params('useid');
        
        $check1=$this->getAthletenbezahlungMapper()->checkbuchungsid($id1);
        $check2=$this->getAthletenbezahlungMapper()->checkathletid($athletid1);
        $check3=$this->getAthletenbezahlungMapper()->checkveranstalter($useid1);
        
        $athletenbezahlung = $this->getAthletenbezahlungMapper()->getAthletenbezahlung($id1);
        
        if($check1!=NULL&&$check2!=NULL&&$check3!=NULL){
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                
                if ($request->getPost()->get('del') == 'Ja') {
                    
                    $this->getAthletenbezahlungMapper()->forwardtoVeranstalter($id1,$athletid1,$useid1,$wert1);
            
                }
                    
                    
                    return $this->redirect()->toRoute('athletenbezahlung');
                    
                    
                
            
                
        }
        
        }

       // $this->getAthletenbezahlungMapper()->forwardtoVeranstalter($id1,$athletid1,$useID1,$wert1);
    
        // zurück zum Index
       return array(
           'id' => $id1,
           'athletid' => $athletid1,
           'wert' => $wert1,
           'useid' => $useid1,
           'athletenbezahlung'=>$athletenbezahlung
           
        );
    
    }
    
    public function forwardgroupAction(){
        
       //Überweist das geld gruppiert nach Verwendungszweck weiter an den Empfänger
        
       // $wertsum = $this->params('sumwert');
       // $useid = $this->params('useid');
        
        
        $url=$_SERVER['REQUEST_URI'];
        
        
        $teile = explode("/", $url);
       
        
        $wertsum1=$teile[6];
        $useid1=$teile[5];
       
        $check1=$this->getAthletenbezahlungMapper()->checkveranstalter($useid1);
        
        
        if($check1!=NULL){
            $request = $this->getRequest();
            
            if ($request->isPost()) {
            
                // Überprüfen welche Sicherheitsabfrage angewählt wurde
                if ($request->getPost()->get('del') == 'Ja') {
            
            
                     
                    $this->getAthletenbezahlungMapper()->forwardgrouptoVeranstalter($useid1,$wertsum1);
            
                }
            
                return $this->redirect()->toRoute('athletenbezahlung');
            }
        }
        
        
       
        
        return array(
            'wertsum' => $wertsum1,
            'useid' => $useid1,
            
        );
    
    }
    
    
    
    
    public function addAction(){
        // erstellt neue Buchung
        
        
        // alle notwendigen Informationen holen iban,bic etc.
        $athletid1 = $this->params('athletid');
        $veranstaltungid1 =  $this->params('useid');
        $wert1 = $this->params('wert');
        
        // Veranstaltungsid wird nicht richtig eingelesen
        echo $veranstaltungid1;
        
        echo "aaaa";
        
        echo $athletid1;
        
        echo "bbbb";
        
        echo $wert1;
        
        echo "cccc";
        
        
        // eventuell noch id einfügen
        $iban1 =$this->getAthletenbezahlungMapper()->iban($athletid1);
        
        
        echo $iban1;
        
        $bic1 = $this->getAthletenbezahlungMapper()->bic($athletid1);
        echo "uuuu";
        
        echo $bic1;
        
        
        $id123 = 0;
        

        $this->getAthletenbezahlungMapper()->athletbezahlungErstellen($id123,$veranstaltungid1,$athletid1,$wert1,$iban1,$bic1);
    
        // zurück zum Index
        return $this->redirect()->toRoute('vereinbezahlung');
    }
    
    
    
    public function getAthletenbezahlungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AthletenbezahlungMapper');
    }
	public function kontenbewegungAction()   
   {           
	$mapper = $this->getAthletenbezahlungMapper();         
	return new ViewModel(array ('athletenbezahlungen' => $mapper->fetchAll()       )  );    
	}
}