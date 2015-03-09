<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Shop\Model\ShopEntity;
use Shop\Form\ShopForm;

/**
 * ShopController
 *
 * @author
 *
 * @version
 *
 */
class ShopController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $form = new ShopForm();
        $shop = new ShopEntity();
        $form->bind($shop);
        $request = $this->getRequest();
        //†berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $menge = $request->getPost('menge');
//             echo "Hallo";
            $form->setData($request->getPost());
            if ($form->isValid()) {
//                 echo "Formular";
                
            }
        }
        $bild = $this->getShopMapper();
        //echo "Index";
        $mapper = $this->getShopMapper();
        return new ViewModel(array(
            'shops' => $mapper->fetchAll(),  'dir' => dirname(__DIR__)
            ,  'bild' => $bild,  'form' => $form
        ));
    }
  
    public function shopveAction()
    {
        $form = new ShopForm();
        $shop = new ShopEntity();
        $form->bind($shop);
        $request = $this->getRequest();
        //†berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $menge = $request->getPost('menge');
//             echo "Hallo";
            $form->setData($request->getPost());
            if ($form->isValid()) {
//                 echo "Formular";
    
            }
        }
        $bild = $this->getShopMapper();
      
        $mapper = $this->getShopMapper();
        return new ViewModel(array(
            'shops' => $mapper->fetchAll(),  'dir' => dirname(__DIR__)
            ,  'bild' => $bild,  'form' => $form
        ));
    }
    
    public function showAction()
    {
        //Auslesen der Ÿbergebenen Id
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('Shop', array('action'=>'add'));
        }
        $shop = $this->getShopMapper()->getShop($id);
        $form = new ShopForm();
        //$shop = new ShopEntity();
        $form->bind($shop);
    
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
    
        //Mapper fŸr das anzeigen der Bilder laden
        $bild = $this->getShopMapper();
        
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt Artikel in den Warenkorb zu legen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        // die †bergabe von Werten
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $menge = $request->getPost('menge');
            $form->setData($request->getPost());
            if ($form->isValid()) {
            
            
                //Laden des Artikels
                $shop = new ShopEntity();
                $shop = $this->getShopMapper()->getShop($id);
            
                //†berprŸfen ob es schon einen Eintrag im Warenkorb fŸr diesen Artikel gibt
                $mapper = $this->getBestellungMapper();
                if($mapper->checkEintrag($shop->getId(), 0, $menge, $veranstalter->getId()))
                {
                    echo "Speichern";
                    //Speichern in den Warenkorb
                    $this->getShopMapper()->saveWarenkorb($veranstalter->getId(), $shop->getId(), $menge);
                }
            
            
                //Auslesen des aktuellen Warenkorbs
                return new ViewModel(array(
                    'bestellungen' => $mapper->fetchAll($veranstalter->getId())
                ));
            }
        }
        return new ViewModel(array(
            'shop' => $shop, 'bild' => $bild,  'form' => $form
        ));
    }
    public function ansichtwarenkorbAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
//         echo "<br>";
 
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt die Artikel aus dem Warenkorb einzusehen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        
        $artikel = $this->getShopMapper();
        
        $mapper = $this->getBestellungMapper();
        return new ViewModel(array(
            'bestellungen' => $mapper->fetchAll($veranstalter->getId()), 'artikel' => $artikel
        ));
    }
    
    public function bestellungenAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
//         echo "<br>";

        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt die aktuellen Bestellungen einzusehen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        $artikel = $this->getShopMapper();
        $mapper = $this->getBestellungMapper();
        return new ViewModel(array(
            'bestellungen' => $mapper->fetchBestellungen($veranstalter->getId()), 'artikel' => $artikel
        ));
    }
    
    public function orderbetreiberAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "SA")
        {
            $this->flashMessenger()->addMessage('Nur dem Betreiber ist es erlaubt die aktuellen Bestellungen einzusehen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
    
        $mapper = $this->getBestellungMapper();
        return new ViewModel(array(
            'bestellungen' => $mapper->fetchBetreiber()
        ));
    }
    
    public function bestellenAction()
    {
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        var_dump($user);
        echo "<br>";
        echo $user['Name'];
        echo $user['Rolle'];
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        echo "<br>";
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt die Artikel aus dem Warenbuch verbindlich zu bestellen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        
        //€ndern des Status von 0(Warenkorb) auf 1(Bestellungen)
        //Finaler Preis wird durch den Betreiber bestimmt und erst dann gann gebucht werden
        $mapper = $this->getBestellungMapper();
        $mapper->bestellen($veranstalter->getId());
        
        $artikel = $this->getShopMapper();
        
        $this->flashMessenger()->addMessage('Bestellung wurde erfolgreich abgeschickt. Die genauen Preise werden ihnen per E-Mailvom Betreiber mitgeteilt');
        
        
                return $this->redirect()->toRoute('shop', array(
                'action' => 'bestellungen', 'artikel' => $artikel ,'bestellungen' => $mapper->fetchBestellungen($veranstalter->getId()
        )));
    }
    
    public function addAction(){
        $form = new ShopForm();
        $shop = new ShopEntity();
    
        $form->bind($shop);
        // die †bergabe von Werten funktioniert noch nicht
        $request = $this->getRequest();
        //†berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
               //Setzen der ArtikelbildId auf Null Setzen, da diese in einer anderen Action gesetzt wird
               $shop->setArtikelbildid(Null);
                
                $this->getShopMapper()->saveShop($shop);
    
                // Redirect to list of tasks
                return $this->redirect()->toRoute('shop');
            }
        }
    
        return array('form' => $form);
    }
    
    public function warenkorbAction(){
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('Shop', array('action'=>'add'));
        }

        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        $veranstalter = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
        
        $form = new ShopForm();
        
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "ve")
        {
            $this->flashMessenger()->addMessage('Nur Veranstaltern ist es erlaubt Artikel in den Warenkorb zu legen');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('shop', array('action' => 'index'));
        }
        // die †bergabe von Werten
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        $menge = $request->getPost('menge');
        $form->setData($request->getPost());
        if ($form->isValid()) {    
            
            
            //Laden des Artikels
            $shop = new ShopEntity();
            $shop = $this->getShopMapper()->getShop($id);
            
            //†berprŸfen ob es schon einen Eintrag im Warenkorb fŸr diesen Artikel gibt
            $mapper = $this->getBestellungMapper();
            if($mapper->checkEintrag($shop->getId(), 0, $menge, $veranstalter->getId()))
            {
//                 echo "Speichern";
                //Speichern in den Warenkorb
                $this->getShopMapper()->saveWarenkorb($veranstalter->getId(), $shop->getId(), $menge);
            }    
             $artikel = $this->getShopMapper();
            
            //Auslesen des aktuellen Warenkorbs
            return new ViewModel(array(
                'bestellungen' => $mapper->fetchAll($veranstalter->getId()), 'artikel' => $artikel
            ));
        
        }
        }
    }
    
    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('Shop', array('action'=>'add'));
        }
        $shop = $this->getShopMapper()->getShop($id);
    
        $form = new ShopForm();
        $form->bind($shop);
    
    
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getShopMapper()->saveShop($shop);
    
                return $this->redirect()->toRoute('shop');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('Shop', array('action'=>'add'));
        }
        $shop = $this->getShopMapper()->getShop($id);
        if (!$shop) {
            return $this->redirect()->toRoute('shop');
        }
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getShopMapper()->deleteShopBestellung($shop);
                $this->getShopMapper()->deleteShop($id);
                $this->getShopMapper()->deleteShopBild($shop);
            }
    
            return $this->redirect()->toRoute('shop');
        }
    
        return array(
            'id' => $id,
            'shop' => $shop
        );
    }
    
    public function getShopMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ShopMapper');
    }
    
    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }

    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }
    
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
    }
    
    public function getBildMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BildMapper');
    }
    
    public function getBestellungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BestellungMapper');
    }
    
}