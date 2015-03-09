<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Event for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\AdminEntity;
use Admin\Form\AdminForm;
use Zend\Form\Element\Time;
use Zend\Form\Element\DateTimeLocal;
use Zend\Form\Element\DateTime;
use Zend\Filter\DateTimeFormatter;

class AdminController extends AbstractActionController
{
	
//Index Admin 
   public function indexAction()
    {
        $mapper = $this->getAdminMapper();
        return new ViewModel(array(
            'admins' => $mapper->fetchAll()
        ));
    }
     
//Admin anzeigen
    public function showAction()
    {
        $id = $this->params('id');
        $admin = $this->getAdminMapper()->getAdmin($id);
        if (! $admin) {
            return $this->redirect()->toRoute('admin');
        }
    }

//Admin hinzufügen
 public function addAction()
    {
        $admin = new AdminEntity();
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new AdminForm($dbAdapter);
        $form->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'datum',
            'options' => array(
                'label' => 'Datum: ',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'min' => date('Y-m-d H:i'),
                'step' => '1'
            )
        )
    );
        $form->bind($admin);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAdminMapper()->saveAdmin($admin);               
//                 Redirect to list of tasks
                return $this->redirect()->toRoute('admin', array(
                    'action' => 'show',
                    'id' => $admin->getAdminid()
                ));
            }
        }
        return array(
            'form' => $form,
            'request' => $request
        );
    }

//Admin bearbeiten
    public function editAction()
    {
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('admin', array(
                'action' => 'add'
            ));
        }
        $admin = $this->getAdminMapper()->getAdmin($id);
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new AdminForm($dbAdapter);
        $form->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'datum',
            'options' => array(
                'label' => 'Datum: ',
                'format' => 'Y-m-d H:i'
            ),
            'attributes' => array(
                'min' => date('Y-m-d H:i'),
                'step' => '1'
            )
         )
      );
        $form->bind($admin);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAdminMapper()->saveAdmin($admin);
                echo"Šndern funktioniert";
                return $this->redirect()->toRoute('admin', array(
                    'action' => 'show',
                    'id' => $admin->getAdminid()
                ));
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'admin' => $admin
        );
    }

//Admin löschen
    public function deleteAction()
    {
        $id = $this->params('id');
        $admin = $this->getAdminMapper()->getAdmin($id);
        if (! $admin) {
            return $this->redirect()->toRoute('admin');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getAdminMapper()->deleteAdminConstraints($admin);
                $this->getAdminMapper()->deleteAdmin($id);
            }
            return $this->redirect()->toRoute('admin');
        }
        return array(
            'id' => $id,
            'admin' => $admin
        );
    }

//AdminMapper
    public function getAdminMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AdminMapper');
    }
   
    
}
