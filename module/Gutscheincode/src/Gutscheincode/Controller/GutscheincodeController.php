<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Gutscheincode for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

 namespace Gutscheincode\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Gutscheincode\Model\Gutscheincode;          
 use Gutscheincode\Form\GutscheincodeForm;       
 use Gutscheincode\Form\GutscheincodeSearchForm;
 use Gutscheincode\Form\GutscheincodeEinloesenForm;
 use Gutscheincode\Form\EinloesenForm;


 
 
 
 class GutscheincodeController extends AbstractActionController
 {
      public function indexAction()
     {
         return new ViewModel(array(
             'gutscheincodes' => $this->getGutscheincodeTable()->fetchAll(), 
         ));
     }
public function athleteinloesenAction() //eingefügt von TW Gruppe 7 am 29.12.14
    {
        $form = new EinloesenForm();
        $form->get('submit')->setValue('Entwerten');
        $request = $this->getRequest();
        if ($request->isPost()) {
			 //eingefügt von TW gruppe7 athlet aus sessionarray auslesen
             $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
             $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
			 
            $gutscheincode = new Gutscheincode;
            //Gutscheinid bekommen
            $id=$this->params()->fromPost('id');
            //ATHLETID BEKOMMEN
 			$athletid = $athlet->id;
            $form->setInputFilter($gutscheincode->getInputFilterSearch());
            $form->setData($request->getPost());
            if($form->isValid()) {
                $gutscheincode->exchangeArray($form->getData());
                $wert = $this->getGutscheincodeTable()->getGutscheinwert($gutscheincode->id);
                print_r($wert);
                //Kontostand abfraagen
                $kontostand=$this->getGutscheincodeTable()->getAthletGuthabenKontostand($athletid);
                print_r($kontostand);
                $neuerKontostand=$kontostand+$wert;
                //Kontostand updaten!
                print_r($neuerKontostand);
                $update=$this->getGutscheincodeTable()->updateAthletGuthabenkontostand($athletid, $neuerKontostand);
                //GutscheincodeDeaktivieren
                $gutscheincode = $this->getGutscheincodeTable()->deactivateGutscheincode($id);
                 return $this->redirect()->toRoute('athlet'
                     , array('controller'=>'athlet', 'action' => 'profil' , 'id' => $id,));
            }
			
        }
        return array('form' => $form);
    }
     public function addAction()
     {
         $form = new GutscheincodeForm();
         $form->get('submit')->setValue('Erstellen');

         $request = $this->getRequest();
         if ($request->isPost()) {

             $gutscheincode = new Gutscheincode();
             //Inputfilter wird Ùbergeben
             $form->setInputFilter($gutscheincode->getInputFilter());
             $form->setData($request->getPost());
             
             //Check ob die Ùbergebenen eingaben gÙltig sind
             if ($form->isValid()) {
                 $gutscheincode->exchangeArray($form->getData());
                 
                 
                 // ALT $this->getGutscheincodeTable()->saveGutscheincode($gutscheincode);
                 $wert= $this->params()->fromPost('wert');
                 if ($wert==1000)
                 {
                     $randCode=$wert.rand(1000000000, 9999999999);
                 }
                 else{
                     $x=0;
                 
                     if (1000>$wert AND $wert> 99)
                     {
                         $randCode=$x.$wert.rand(1000000000, 9999999999);
                     }
                     elseif (100>$wert AND $wert> 9)
                     {
                         $randCode=$x.$x.$wert.rand(1000000000, 9999999999);
                     }
                     else if (10>$wert)
                     {
                         $randCode=$x.$x.$x.$wert.rand(1000000000, 9999999999);
                     }
                 }
                 $this->getGutscheincodeTable()->generarteAndInsertGutscheincode($gutscheincode, $randCode);
                 // Redirect to list of gutscheincodes
                return $this->redirect()->toRoute('gutscheincode'
                , array('controller'=>'gutschein', 'action' => 'show', 'id' => $randCode,));

             }
         }
         return array('form' => $form);
     }
     
     public function searchgutscheincodeAction()
     {
         $form = new GutscheincodeSearchForm();
         $form->get('submit')->setValue('Suchen');
         $request = $this->getRequest();
         if ($request->isPost()) {
             
             $gutscheincode = new Gutscheincode;
             
             //POST FUNKTION WERT WIRD HIER VON FORMULAR AN CONTROLLER UEBERGEBEN
             $id= $this->params()->fromPost('id'); ;
             
             $form->setInputFilter($gutscheincode->getInputFilterSearch());
             $form->setData($request->getPost());
             if($form->isValid()) {
                 $gutscheincode->exchangeArray($form->getData());
                 $gutscheincode = $this->getGutscheincodeTable()->fetchCode($id);
              return $this->redirect()->toRoute('gutscheincode'
                , array('controller'=>'gutschein', 'action' => 'show' , 'id' => $id,));
                 
             }
         }
         return array('form' => $form);
         }

     public function showAction()
     {

        $id = $this->params('id');
        $gutscheincode = $this->getGutscheincodeTable()->fetchCode($id);
        if (!$gutscheincode) {
            return $this->redirect()->toRoute('gutscheincode');
        }
        
        $gutscheincode = $this->getGutscheincodeTable()->fetchCode($id);

        
        return new ViewModel(array(
            'gutscheincodes' => $gutscheincode
        ));
     }
     
     public function showopenAction()
     {
         return new ViewModel(array(
             'gutscheincodes' => $this->getGutscheincodeTable()->fetchOpenGutscheincodes(),
         ));
     }
     
     public function showclosedAction()
     {
         return new ViewModel(array(
             'gutscheincodes' => $this->getGutscheincodeTable()->fetchClosedGutscheincodes(),
         ));
     }
     
     public function showallAction()
     {
         return new ViewModel(array(
             'gutscheincodes' => $this->getGutscheincodeTable()->fetchAll(),
         ));
     }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('gutscheincode');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('Ja', 'Nein');
        
            if ($del == 'Ja') {
                $id = (int) $request->getPost('id');
                $this->getGutscheincodeTable()->deleteGutscheincode($id);
            }
        
            // Redirect to list of Gutscheincodes
            return $this->redirect()->toRoute('gutscheincode');
        }
        
        return array(
            'id'    => $id,
            'gutscheincode' => $this->getGutscheincodeTable()->getGutscheincode($id)
        );
    }
    //deaktivierenfunktion noch einsetzen
    public function einloesenAction()
    {
        $form = new GutscheincodeEinloesenForm();
        $form->get('submit')->setValue('Entwerten');
        $request = $this->getRequest();
        if ($request->isPost()) {
             
            $gutscheincode = new Gutscheincode;
            //Gutscheinid bekommen
            $id=$this->params()->fromPost('id');
            //ATHLETID BEKOMMEN
            $athletid=$this->params()->fromPost('athletenid');
            $form->setInputFilter($gutscheincode->getInputFilterSearch());
            $form->setData($request->getPost());
            if($form->isValid()) {
                $gutscheincode->exchangeArray($form->getData());
                $wert = $this->getGutscheincodeTable()->getGutscheinwert($gutscheincode->id);
                print_r($wert);
                //Kontostand abfraagen
                $kontostand=$this->getGutscheincodeTable()->getAthletGuthabenKontostand($athletid);
                print_r($kontostand);
                $neuerKontostand=$kontostand+$wert;
                //Kontostand updaten!
                print_r($neuerKontostand);
                $update=$this->getGutscheincodeTable()->updateAthletGuthabenkontostand($athletid, $neuerKontostand);
                //GutscheincodeDeaktivieren
                $gutscheincode = $this->getGutscheincodeTable()->deactivateGutscheincode($id);
                 return $this->redirect()->toRoute('gutscheincode'
                     , array('controller'=>'gutschein', 'action' => 'show' , 'id' => $id,));
            }
        }
        return array('form' => $form);
    }
    
    public function athletAction()
    {
        return new ViewModel(array(
            'athleten' => $this->getAthletTable()->fetchAll(),
        ));
    }

     // getGutscheincodeTable wird zb in index Aufgerufen
     public function getGutscheincodeTable() 
     {
        if (!$this->gutscheincodeTable) {
             $sm = $this->getServiceLocator();
             $this->gutscheincodeTable = $sm->get('Gutscheincode\Model\GutscheincodeTable');
         }
         return $this->gutscheincodeTable;
     }
     
     protected $gutscheincodeTable;
	  public function getUserMapper() //eingefügt von TW gruppe7 um aus sessionarray auszulesen
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }
     
     public function getAthletTable()
     {
         if (!$this->athletTable) {
             $sm = $this->getServiceLocator();
             $this->athletTable = $sm->get('Gutscheincode\Model\AthletTable');
         }
         return $this->athletTable;
     }
      
     protected $athletTable;
     
     
 }
 
 
 
 