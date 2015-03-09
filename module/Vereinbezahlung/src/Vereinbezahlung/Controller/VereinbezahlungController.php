<?php
namespace Vereinbezahlung\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vereinbezahlung\Model\VereinbezahlungEntity;
use Vereinbezahlung\Form\VereinbezahlungForm;

/**
 * VeranstalterController
 *
 * @author
 *
 * @version
 *
 */
class VereinbezahlungController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getVereinbezahlungMapper();
        return new ViewModel(array(
            'vereinbezahlungen' => $mapper->fetchAll()
        ));
    }
    
    public function searchAction(){
    
        $form = new VereinbezahlungForm();
        $vereinbezahlung = new VereinbezahlungEntity();
        $form->bind($vereinbezahlung);
        // die †bergabe von Werten funktioniert noch nicht
    
       //mit id ist hier die Vereinsid gemeint
    
        if(isset($_REQUEST['id'])){
            $id1 = $_REQUEST['id'];
            $useid1 = $_REQUEST['useid'];
            $mapper = $this->getVereinbezahlungMapper();
            return new ViewModel(array(
                'vereinbezahlungen' => $mapper->fetchAllindividuell($id1,$useid1)
            
            ));
        }  else{
            return array('form' => $form,
                'vereinbezahlungen' => NULL,
            );
        }
            
        
    
        
    }
    
    public function groupAction()
    {
    
    
        $mapper = $this->getVereinbezahlungMapper();
        return new ViewModel(array(
            'vereinbezahlungen' => $mapper->fetchAllgroup()
        ));
    }
    
    
    
    public function forwardAction(){
    
        
        $id1 = $this->params('id');
        $vereinid1 = $this->params('vereinid');
        $wert1 = $this->params('wert');
        $useID1 = $this->params('useid');
        
    $vereinsbezahlung = $this->getVereinbezahlungMapper()->getVereinbezahlung($id1);
    
    $check1 = $this->getVereinbezahlungMapper()->checkbuchungsid($id1);
    $check2 = $this->getVereinbezahlungMapper()->checkveranstalter($useID1);
    $check3 = $this->getVereinbezahlungMapper()->checkverein($vereinid1);
    
    if($check1!=NULL && $check2!=NULL && $check3!=NULL){
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Ja') {
        
        
                $this->getVereinbezahlungMapper()->forwardtoVeranstalter($id1,$vereinid1,$useID1,$wert1);
        
            }
        
            return $this->redirect()->toRoute('vereinbezahlung');
        }
    }
 
    return array(
        'id' => $id1,
        'vereinid' => $vereinid1,
        'wert' => $wert1,
        'useID' => $useID1,
        'vereinbezahlung'=>$vereinsbezahlung
         
    );


    }
    
    public function forwardgroupAction(){
        
        //Werte werden nicht aus der URL ausgelesen
        //$wert1 = $this->params('wert');
        //$useID1 = $this->params('useid');
        
        //var_dump($wert1);
        //var_dump($useID1);
        $url=$_SERVER['REQUEST_URI'];
        var_dump($url);
        
        $teile = explode("/", $url);
        var_dump($teile);
        
        $wert1=$teile[6];
        $useID1=$teile[5];
        
        $check2 = $this->getVereinbezahlungMapper()->checkveranstalter($useID1);
        
        if($check2!=NULL){
            $request = $this->getRequest();
            
            if ($request->isPost()) {
            
                if ($request->getPost()->get('del') == 'Yes') {
            
                    $this->getVereinbezahlungMapper()->forwardgrouptoVeranstalter($useID1,$wert1);
            
                }
                return $this->redirect()->toRoute('vereinbezahlung');
            }
        }
        
        
        // zurück zum Index
        return array(
           
            'wert' => $wert1,
            'useid' => $useID1
             
        );  
 }
    
    
    public function backAction(){
        //Auslesen der parameter-> werden erfolgreich übergeben
        $id1 = $this->params('id');
        $vereinid1 = $this->params('vereinid');
        $wert1 = $this->params('wert');
        
        $vereinsbezahlung = $this->getVereinbezahlungMapper()->getVereinbezahlung($id1);
        
        
        $check1 = $this->getVereinbezahlungMapper()->checkbuchungsid($id1);
        $check2 = $this->getVereinbezahlungMapper()->checkverein($vereinid1);
        
       // if($check1!=NULL && $check2!=NULL){
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                if ($request->getPost()->get('del') == 'Ja') {
            
            
                    $this->getVereinbezahlungMapper()->backtoVerein($id1,$vereinid1,$wert1);
            
                }
            
                return $this->redirect()->toRoute('vereinbezahlung');
            }
       // }
        
        
        
        
        return array(
            'id' => $id1,
            'vereinid' => $vereinid1,
            'wert' => $wert1,
          
            'vereinbezahlung'=>$vereinsbezahlung
             
        );
    }
    

        public function addAction(){
        // erstellt neue Buchung
        
        // alle notwendigen Informationen holen iban,bic etc.
        $vereinid1 = $this->params('vereinid');
        $veranstaltungid1 =  $this->params('useid');
        $wert1 = $this->params('useid');
        
        // Veranstaltungsid wird nicht richtig eingelesen
        echo $vereinid1;
        echo "aaaa";
        echo $veranstaltungid1;
        
        echo "bbbb";
        echo $wert1;
        echo "cccc";
        
        
        // eventuell noch id einfügen
        $iban1 =$this->getVereinbezahlungMapper()->iban($vereinid1);
        
        
        echo $iban1;
        
        $bic1 = $this->getVereinbezahlungMapper()->bic($vereinid1);
        echo "uuuu";
        
        echo $bic1;
        $id123 = 0;
        
        
  
    
    
        $this->getVereinbezahlungMapper()->vereinbezahlungErstellen($id123,$veranstaltungid1,$vereinid1,$wert1,$iban1,$bic1);
    
        // zurück zum Index
        return $this->redirect()->toRoute('vereinbezahlung');
    }
    

    public function getVereinbezahlungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VereinbezahlungMapper');
    }
}