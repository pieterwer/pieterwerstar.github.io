<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Suche for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Suche\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Suche\Model\Athlet;                
 use Suche\Form\AthletSearchForm;

 
class SucheController extends AbstractActionController
{
    public function indexAction()
    {
         $form = new AthletSearchForm();
         $form->get('submit')->setValue('Suchen');
         $request = $this->getRequest();
         if ($request->isPost()) {
             
             $athlet = new Athlet;
             
             //POST FUNKTION WERT WIRD HIER VON FORMULAR AN CONTROLLER UEBERGEBEN
             $name= $this->params()->fromPost('Name'); 
             $vorname= $this->params()->fromPost('Vorname');
             //BEI LEEREM FORMULARFELD
             if ($vorname=='') $vorname='empty';
             if ($name=='') $name='empty';

             $form->setData($request->getPost());

              return $this->redirect()->toRoute('suche'
                , array('controller'=>'suche', 'action' => 'show' , 'vorname' => $vorname, 'name'=>$name));
                 
             }
         
         return array('form' => $form);
    }

     public function searchathletAction()
     {
         $form = new AthletSearchForm();
         $form->get('submit')->setValue('Suchen');
         $request = $this->getRequest();
         if ($request->isPost()) {
             
             $athlet = new Athlet;
             
             //POST FUNKTION WERT WIRD HIER VON FORMULAR AN CONTROLLER UEBERGEBEN
             $name= $this->params()->fromPost('Name'); 
             $vorname= $this->params()->fromPost('Vorname');
             //BEI LEEREM FORMULARFELD
             if ($vorname=='') $vorname='empty';
             if ($name=='') $name='empty';

             $form->setData($request->getPost());

              return $this->redirect()->toRoute('suche'
                , array('controller'=>'suche', 'action' => 'show' , 'vorname' => $vorname, 'name'=>$name));
                 
             }
         
         return array('form' => $form);
         }
       
         
         
         public function showAction()
         {
             $name = $this->params('name');
             $vorname = $this->params('vorname');
         
             if ($name!='empty' && $vorname=='empty')
                 $athlet = $this->getAthletTable()->getAthletName($name);
             if ($name=='empty' && $vorname!='empty')
                 $athlet = $this->getAthletTable()->getAthletVorname($vorname);
             if ($name!='empty' && $vorname!='empty')
                 $athlet = $this->getAthletTable()->getAthletVornameName($vorname,$name);
         
         
             if (!$athlet) {
                 return $this->redirect()->toRoute('suche');
             }
             return new ViewModel(array(
                 'athleten' => $athlet
             ));
         }
    
         
     protected $athletTable;
     
     public function getAthletTable()
     {
         if (!$this->athletTable) {
             $sm = $this->getServiceLocator();
             $this->athletTable = $sm->get('Suche\Model\AthletTable');
         }
         return $this->athletTable;
     }
     

}
