<?php

// erstellt von Philipp am 05.12.14
namespace Starmina\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Starmina\Model\Verein;
use Starmina\Model\Logindaten;
use Starmina\Model\VereinTable;
use Starmina\Form\VereinRegistrierungForm;
use Starmina\Form\VereinsAdminWechselForm;
use Starmina\Model\VereinBuchung;
use Starmina\Model\VereinBuchungTable;


class VereinController extends AbstractActionController {
	protected $vereinTable;
	protected $logindatenTable;
	protected $athletTable;
	protected $vereinBuchungTable;
	public function profilAction() {
		/*
		 * Hiermit l�sst sich die Buchung testen.
		 */
		// $buchung = new VereinBuchung ();
		// $buchung->Vereinid = 15;
		// $buchung->IBAN = "1337";
		// $buchung->BIC = "1566";
		// $buchung->Wert = "42";
		// $buchung->Datum = "2015-01-14";
		// $this->getVereinBuchungTable ()->buchen ( $buchung );
		
		$user = $this->getServiceLocator ()->get ( 'AuthService' )->getStorage ()->read ();
		$verein = $this->getUserMapper ()->getUserobject ( $user ['Rolle'], $user ['Name'] );
		return new ViewModel ( array (
				'verein' => $verein 
		) );
		
		// zum testen falls Login nicht geht
// 		return new ViewModel ( array (
// 				'verein' => $this->getVereinTable ()->fetchAll ()->current () 
// 		) );
	}
	public function registrierenAction() {
		$form = new VereinRegistrierungForm ();
		$form->get ( 'vreg' )->setValue ( 'Registrieren' ); // PR weuß nicht, ob hier ein setValue sein muss
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$verein = new Verein ();
			$form->setInputFilter ( $verein->getInputFilter () ); // Input-Filter in Datenbank-Klasse auslagern
			$logindaten = new Logindaten ();
			// $form->setInputFilter($logindaten->getInputFilter());
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$test = $form->getData ();
				$verein->exchangeArray ( $form->getData () );
				$logindaten->exchangeArray ( $form->getData () );
				
				$this->getLogindatenTable ()->saveLogindaten_verein ( $logindaten );
				$this->getVereinTable ()->saveVerein ( $verein );
				
				// return $this->redirect()->toRoute('verein');
				// Redirect zu Profilübersicht für Verein
				// nicht mehr, da jetzt child route (PR, 13.12.14)
				
				
				 return $this->redirect()->toRoute('success');
			}
			
			// die Form ist wohl nicht Valid...da blick ich nicht ganz durch, ist auch nur eine Notlösung, soweit ich das sehe. vllt. stimmt auch was mit den Datentypen nicht überein (TW)
			// häh? wieso vorübergehende Lösung? Ich bleib beim TableGateway Verfahren, oder meist was anderes? (12.12.14)
			// form ist etz Valid :) => else Block vom Tobi demnach sinnlos, hab ich (PR) also auskommentiert (13.12.14)
			
			/*
			 * else {
			 * $verein->exchangeArray($form->getData());
			 * $logindaten->exchangeArray($form->getData());
			 * $this->getLogindatenTable()->saveLogindaten_verein($logindaten);
			 * $this->getVereinTable()->saveVerein($verein);
			 *
			 * // return $this->redirect()->toRoute('verein');
			 * // Redirect zu Profilübersicht für Verein
			 * // nicht mehr, da jetzt child route (PR, 13.12.14)
			 *
			 * return $this->redirect()->toRoute('verein', array('action'=>'profil', 'id' => $id));
			 * }
			 */
		}
		return array (
				'form' => $form 
		);
	}
	public function vregresetAction() // Vereins-Registrierungs-Formulare zurücksetzen
{
		$form = new VereinRegistrierungForm ();
		$form->get ( 'vregreset' )->setValue ( '' );
		
		// return $this->redirect()->toRoute('verein/registrieren'); // sinnlos, da Missing parameter "id"
		// will einen Parameter, also geb ich ihm einen Parameter:
		
		return $this->redirect ()->toRoute ( 'verein', array (
				'action' => 'registrieren',
				'id' => $id 
		) );
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'verein', array (
					'action' => 'registrieren' 
			) );
		}
		
		// Get the Album with the specified id. An exception is thrown
		// if it cannot be found, in which case go to the index page.
		try {
			$verein = $this->getVereinTable ()->getVerein ( $id );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'verein', array (
					'action' => 'profil' 
			) );
		}
		
		$form = new VereinRegistrierungForm ();
		$form->bind ( $verein );
		$form->get ( 'vreg' )->setAttribute ( 'value', 'Edit' );
		
		// ---
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $verein->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$verein->id = $id;
				$this->getVereinTable ()->updateVerein ( $verein );
				
				// Redirect to list of albums
				return $this->redirect ()->toRoute ( 'verein', array (
						'action' => 'profil' 
				) );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
	}
	public function wechselAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		$verein = $this->getVereinTable ()->getVerein ( $id );
		$alteEmail = $verein->Adminemail;
		
		$form = new VereinsAdminWechselForm ();
		$form->get ( 'wechsel' )->setValue ( 'Vereinsadministratorwechsel beantragen' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			
			// $verein = new Verein ();
			$form->setInputFilter ( $verein->getAdminWechselInputFilter () );
			$logindaten = new Logindaten ();
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$test = $form->getData ();
				$verein->exchangeArray ( $form->getData () );
				$logindaten->exchangeArray ( $form->getData () );
				$this->getLogindatenTable ()->saveLogindaten_verein ( $logindaten );
				$verein2 = $this->getVereinTable ()->getVerein ( $id );
				$verein2->Status = 0;
				$verein2->Adminemail = $test ['Adminemail'];
				$verein2->Vereinsvertreter = $test ['Vereinsvertreter'];
				$this->getVereinTable ()->updateVerein ( $verein2 );
				$this->getLogindatenTable ()->deleteLoginDaten ( $alteEmail );
				// logout machen
				
				// return $this->redirect ()->toRoute ( 'verein', array (
				// 'action' => 'profil'
				// ) );
				return $this->redirect ()->toRoute ( 'verein', array (
						'action' => 'bestatigung' 
				) );
			}
		}
		return array (
				'form' => $form,
				'id' => $id 
		);
	}
	public function bestatigungAction() {
		return new ViewModel ( array (
				'message' => 'Erfolgreich!' 
		) );
	}
	public function getVereinTable() {
		if (! $this->vereinTable) {
			$sm = $this->getServiceLocator ();
			$this->vereinTable = $sm->get ( 'Starmina\Model\VereinTable' );
		}
		return $this->vereinTable;
	}
	public function getAthletTable() {
		if (! $this->athletTable) {
			$sm = $this->getServiceLocator ();
			$this->vereinTable = $sm->get ( 'Starmina\Model\AthletTable' );
		}
		return $this->vereinTable;
	}
	public function getLogindatenTable() {
		if (! $this->logindatenTable) {
			$sm = $this->getServiceLocator ();
			$this->logindatenTable = $sm->get ( 'Starmina\Model\LogindatenTable' );
		}
		return $this->logindatenTable;
	}
	public function getVereinBuchungTable() {
		if (! $this->vereinBuchungTable) {
			$sm = $this->getServiceLocator ();
			$this->vereinBuchungTable = $sm->get ( 'Starmina\Model\VereinBuchungTable' );
		}
		return $this->vereinBuchungTable;
	}
	public function getUserMapper() {
		$sm = $this->getServiceLocator ();
		return $sm->get ( 'UserMapper' );
	}
}