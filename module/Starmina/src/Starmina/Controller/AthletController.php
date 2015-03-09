<?php

namespace Starmina\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Starmina\Model\Athlet;        
 use Starmina\Model\Logindaten;
 use Starmina\Model\Anschrift;
 use Starmina\Model\Bild;
 use Starmina\Model\AthletenGuthaben;
 use Starmina\Model\MotivationZuordnung;
 use Athleteinsicht\Model\AthleteinsichtEntity;
 //use Starmina\Model\SportartZuordnung;
 
 // Hinzufügen von \File\Size damit Zend darauf zugreifen kann
 // Hinzugefügt Alex Giedt 16.12
 
 use Zend\Validator\File\Size;
 
 // use Starmina\Model\Sportart;      
 use Starmina\Form\AthletRegistrierungForm;
 use Starmina\Form\AnschriftForm;
 

 class AthletController extends AbstractActionController
 {
	 protected $athletTable;
	 protected $logindatenTable;
	 protected $anschriftTable;
	 //protected $motivationzuordnungTable;
	 //protected $sportartzuordnungTable
	 protected $bildTable;
	 protected $athletenguthabenTable;
	  
	  
	 public function homeAction()
     {
		  return new ViewModel();
            
     }
	 
	
	  
     public function profilAction()
     {
		  $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
          $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        
		  return new ViewModel(array(
             'athlet' => $athlet,
			 'athletenguthaben' =>$this->getAthletenGuthabenTable()->getAthletenGuthaben($athlet->id),
			 // 'bild' => $this->getBildTable()->getBild($athlet->id)
         ));
     }

     


     public function registrierenAction()
     {
		 
		 //print_r($this->getMotivationTable()->fetchAll());
		 
		 
		 $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		 $form = new AthletRegistrierungForm($dbAdapter);
       		 
		 
		 // hier muss die Motivationload Funktion hin vor Abschließen der Registrierung
		 
		 
		 
         $form->get('areg')->setValue('Registrieren');

         $request = $this->getRequest();
         if ($request->isPost()) {
			 
             $athlet = new Athlet();
			 $athletenguthaben = new AthletenGuthaben();
			 
			 
			 
		 // oder auch hier muss die Motivationload Funktion hin vor Abschließen der Registrierung
		 
		 // image-file wird in $File gespeichert
		    $File    = $this->params()->fromFiles('image-file');
			print_r($this->params()->fromFiles('image-file'));
		 	$post = array_merge_recursive(
            	$request->getPost()->toArray(),
            	$request->getFiles()->toArray()
			);
		
             $form->setInputFilter($athlet->getInputFilter());
			 $logindaten = new Logindaten();
             // $form->setInputFilter($logindaten->getInputFilter());
			 $anschrift = new Anschrift();
			 // $form->setInputFilter($anschrift->getInputFilter());
			 $bild = new Bild();
			 ////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
			 
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
			//$motivationzuordnung = new MotivationZuordnung();
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
			// $sportartzuordnung = new SportartZuordnung();
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
			 
			 
			 
             $form->setData($post);
			print_r($post);
						
             if ($form->isValid()) {
				 print_r($form->getData());
				 
				 //minimum bytes filesize: 300 x 300 Pixel => 90000 Bytes Alex Giedt 16.12
				 
				 $size = new Size(array('min'=>9000)); 
     
    			$adapter = new \Zend\File\Transfer\Adapter\Http(); 
    			//validator can be more than one...
    			$adapter->setValidators(array($size), $File['name']);
     
				if (!$adapter->isValid()){
					$dataError = $adapter->getMessages();
					$error = array();
					foreach($dataError as $key=>$row)
					{
						$error[] = $row;
					}
					 //setzen von formElementErrors
					 
					$form->setMessages(array('fileupload'=>$error ));
					print_r($form->getMessages());
					
					$athlet->exchangeArray($form->getData());
					$athlet->exchangeArray($form->getData());
					$logindaten->exchangeArray($form->getData());
							 
					$anschrift->exchangeArray($form->getData()); 
					
					////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
					//$motivationzuordnung->exchangeArray($form->getData());
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
					//$sportartzuordnung->exchangeArray($form->getData());
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
							 
					$this->getLogindatenTable()->saveLogindaten($logindaten);
							 
					$id = $this->getAthletTable()->saveAthlet($athlet);
							 
					$anschrift->setId($id);
							 
					$this->getAnschriftTable()->saveAnschrift($anschrift);
					
					$athletenguthaben->setId($id);
					$this->getAthletenGuthabenTable()->saveAthletenGuthaben($athletenguthaben);
					////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
					//$motivationzuordnung->setId($id);
					//$this->getMotivationZuordnungTable()->saveMotivationZuordnung($motivationzuordnung);
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
					//$sportartzuordnung->setId($id);
					//$this->getSportartZuordnungTable()->saveSportartZuordnung($sportartzuordnung);
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
					
						/* return $this->redirect ()->toRoute ( 'athlet', array (
						'action' => 'profil',
						'id' => $id 
				) ) */
				 return $this->redirect()->toRoute('success');
					
							 
				}else {
					
					//festlegen des Directory wo das Bild gespeichert werden soll
					//Bei mir (Alex Giedt): Macintosh HD ▸ Programme ▸ XAMPP ▸ xamppfiles ▸ htdocs ▸ group7starmina1412 ▸ 				                      module ▸ Starmina ▸ src ▸ Starmina ▸ assets
					//bei dieser Lösung muss man bei der Registrierung ein Bild hochladen, da sonst die Daten nicht in die                     				                      DB übernommen werden. Arbeite aber noch daran, dass Reg auch ohne Bild Upload geht. Habe mir in			                      meiner DB in der der Athleten Tabelle eine Spalte Bildname erstellt, da die Bild.php / BildTable.php                      noch fehlt / noch nicht richtig geht Alex Giedt 16.12
					
		echo dirname(__DIR__).'/assets';
					$adapter->setDestination(dirname(__DIR__).'/assets');
					if ($adapter->receive($File['name'])) {
						
						//$profile->exchangeArray($form->getData());
						$athlet->exchangeArray($form->getData());
						
						//Fehlermeldung kann irgnoriert werden, ist nur Hilfe für mich um zu sehen ob Upload passiert oder
						//nicht (Alex Giedt 16.12)
						//print_r(' upload '.$athlet->bild_athlet);
						
						$athlet->exchangeArray($form->getData());
							 $logindaten->exchangeArray($form->getData());
							 
							 $anschrift->exchangeArray($form->getData()); 
							 
							 
							 $bild->exchangeArray($form->getData());
							 
							// $id = $this->getAthletTable()->saveBild($athlet);
							 
							 
							 $picid = $this->getBildTable()->saveBild($bild);
							 $athlet->setbildid($picid);
							 
							 $this->getLogindatenTable()->saveLogindaten($logindaten);
							 
							 $id = $this->getAthletTable()->saveAthlet($athlet);
							 
							 $anschrift->setId($id);
							 
							 $this->getAnschriftTable()->saveAnschrift($anschrift);
							 ////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
							 //$motivationzuordnung->setId($id);
							 //$this->getMotivationZuordnungTable()->saveMotivationZuordnung($motivationzuordnung);
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
							//$sportartzuordnung->setId($id);
							//$this->getSportartZuordnungTable()->saveSportartZuordnung($sportartzuordnung);
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
							 
							 return $this->redirect ()->toRoute ( 'athlet', array (
						'action' => 'profil',
						'id' => $id 
							) );
							 
							 
					}
				}   
				
                 // Redirect to Profilübersicht
				
                 //return $this->redirect()->toRoute('athlet', array('action'=>'profil', 'id' => $id));
             }//else{
			 	//print_r("LUSTIGES TESTEN");
			 //}
         }
         return array('form' => $form);
     }
	 
	 
	 public function aregresetAction() // Athleten-Registrierungs-Formulare zurücksetzen
	 {
		 $form = new AthletRegistrierungForm();
         $form->get('aregreset')->setValue('');
		 
		 // return $this->redirect()->toRoute('verein/registrieren'); // sinnlos, da Missing parameter "id"
		 // will einen Parameter, also geb ich ihm einen Parameter:
		 
		 return $this->redirect()->toRoute('athlet', array('action'=>'registrieren', 'id' => $id));
     }
	 
	 
     public function editanschriftAction()
	 {	 
          $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('athlet', array(
                 'action' => 'registrieren'
             ));
			 
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
			 $anschrift = $this->getAnschriftTable()->getAnschrift($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('athlet', array(
                 'action' => 'profil'
             ));
         }
		 
		
         $form  = new AnschriftForm();
         $form->bind($anschrift);
         $form->get('areg')->setAttribute('value', 'Bearbeiten');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($anschrift->getAnschriftInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
				 $anschrift->id = $id;
				 $this->getAnschriftTable()->updateAnschrift($anschrift);
		return $this->redirect ()->toRoute ('athlet', array (
					'action' => 'profil'));        
			}
		 
  
     }
	       return array(
             'id' => $id,
             'form' => $form,
         );
	 }
 	 
	

     public function deleteAction()
     {
		  $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('athlet');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'Nein');


             if ($del == 'Ja') {
				 $Email = $this->getAthletTable()->getEmail($id);
				 //$this->getAthletenbezahlungMapper()->deleteAthletenbezahlung($id);
//				 $this->getErgebnisMapper()->deleteErgebnis($id); // Historie soll eigentlich unberührt bleiben, dasss ist allerdings wegen foreign key constraints unmöglich
//				 $this->getAthletenGuthabenTable()->deleteAthletenGuthaben($id);
//				 $this->getAnschriftTable()->deleteAnschrift($id);
//                 $this->getAthletTable()->deleteAthlet($id);
//				 $this->getLogindatenTable()->deleteLogindaten($Email);
				$this->getLogindatenTable()->updateRolle($Email);
				
				 
             }

         
         }

         return array(
             'id'    => $id,
             'athlet' => $this->getAthletTable()->getAthlet($id)
         );
     }
	 
	 
	 public function getAthletTable()
     {
         if (!$this->athletTable) {
             $sm = $this->getServiceLocator();
             $this->athletTable = $sm->get('Starmina\Model\AthletTable');
         }
         return $this->athletTable;
     }
	 
	 
	 
	 
	 public function getLogindatenTable()
     {
         if (!$this->logindatenTable) {
             $sm = $this->getServiceLocator();
             $this->logindatenTable = $sm->get('Starmina\Model\LogindatenTable');
         }
         return $this->logindatenTable;
     }
	 
	 
	 public function getAnschriftTable()
     {
         if (!$this->anschriftTable) {
             $sm = $this->getServiceLocator();
             $this->anschriftTable = $sm->get('Starmina\Model\AnschriftTable');
         }
         return $this->anschriftTable;
     }
	 
	 
	 /* 
	 public function getMotivationZuordnungTable()
     {
         if (!$this->motivationzuordnungTable) {
             $sm = $this->getServiceLocator();
             $this->motivationzuordnungTable = $sm->get('Starmina\Model\MotivationZuordnungTable');
         }
         return $this->motivationzuordnungTable;
     }
	 
	 public function getSportartZuordnungTable()
     {
         if (!$this->sportartzuordnungTable) {
             $sm = $this->getServiceLocator();
             $this->sportartzuordnungTable = $sm->get('Starmina\Model\SportartZuordnungTable');
         }
         return $this->sportartzuordnungTable;
     }*/
	 
	  public function getBildTable()
     {
         if (!$this->bildTable) {
             $sm = $this->getServiceLocator();
             $this->bildTable = $sm->get('Starmina\Model\BildTable');
         }
         return $this->bildTable;
     }
	 
	  
	 public function getAthletenGuthabenTable()
     {
         if (!$this->athletenguthabenTable) {
             $sm = $this->getServiceLocator();
             $this->athletenguthabenTable = $sm->get('Starmina\Model\athletenguthabenTable');
         }
         return $this->athletenguthabenTable;
     }
	 public function getAthletenbezahlungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AthletenbezahlungMapper');
    }
	
	public function getErgebnisMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ErgebnisMapper');
    }
	public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }
	public function getAthleteinsichtMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AthleteinsichtMapper');
    }
	 
 }