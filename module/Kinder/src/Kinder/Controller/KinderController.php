<?php
namespace Kinder\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Kinder\Model\KinderEntity;
use Kinder\Form\KinderForm;

/**
 * KinderController
 *
 * @author
 *
 * @version
 *
 */
class KinderController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getKinderMapper();
        return new ViewModel(array(
            'kinder' => $mapper->fetchAll()
        ));
    }

    public function auswahlAction()
    {
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('event');
        }
        
        $ev = (int) $this->params('ev');
        if (! $id) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        $event = $this->getEventMapper()->getEvent($ev);
        
        $form = new KinderForm();
        
        $mapper = $this->getKinderMapper();
        return new ViewModel(array(
            'kinder' => $mapper->fetchChild($id), 'form' => $form, 'event' => $event
        ));
    }
    
    public function addAction(){
        $form = new KinderForm();
        $kind = new KinderEntity();
        
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);

        error_reporting(0);
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        error_reporting(E_ALL);
        
    
        $form->bind($kind);
        
        //†berprŸfen ob der user auch ein Veranstalter ist
        if($user['Rolle'] != "at")
        {
            $this->flashMessenger()->addMessage('Nur fŸr Athleten erlaubt');
            // Redirect to list of tasks
            //Route muss noch angepasst werden
            return $this->redirect()->toRoute('event', array('action' => 'index'));
        }

        $request = $this->getRequest();
        //†berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //†bergabe der Athletid
                $kind->setAthletid($athlet->id);
                
                $this->getKinderMapper()->saveKind($kind);
    
                // Redirect to list of tasks
                return $this->redirect()->toRoute('kinder');
            }
        }
    
        return array('form' => $form);
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('kinder', array('action'=>'index'));
        }
        $kind = $this->getKinderMapper()->getKind($id);
        if (!$kind) {
            return $this->redirect()->toRoute('kinder');
        }
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getKinderMapper()->deleteKind($kind->getId());
            }
    
            return $this->redirect()->toRoute('kinder');
        }
    
        return array(
            'id' => $id,
            'kind' => $kind
        );
    }
    
    public function getKinderMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('KinderMapper');
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
    
}