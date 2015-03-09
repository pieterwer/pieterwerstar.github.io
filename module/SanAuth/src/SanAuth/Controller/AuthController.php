<?php

namespace SanAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Session\Container;
use SanAuth\Model\LoginEntity;
use SanAuth\Model\User;


class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }

        return $this->authservice;
    }

    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('SanAuth\Model\MyAuthStorage');
        }

        return $this->storage;
    }

    public function getForm()
    {
        if (! $this->form) {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }

        return $this->form;
    }

    public function loginAction()
    {
        //if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()) {
            
            return $this->redirect()->toRoute('success');
        }

        $form       = $this->getForm();
        
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }

    public function authenticateAction()
    {
        $form       = $this->getForm();
        $redirect = 'login';

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential(md5($request->getPost('password')));

                $result = $this->getAuthService()->authenticate();
                foreach ($result->getMessages() as $message) {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }

                if ($result->isValid()) {
                    $redirect = 'success';
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //set storage again
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    
                    
                    $this->getAuthService()->setStorage($this->getSessionStorage());
                    
                    // write() schreibt �bergebene Werte in den Sessionstorage
                    
                    
                    // Holen der Logindaten
                    $mapper = $this->getLoginMapper();
                    $loginentity=$mapper->setLoginData($request->getPost('username'),$request->getPost('password'));
                    
                    $Rolle=$loginentity->getRolle();
                    
                    $verfifiziert=NULL;
                    
                    if($Rolle=="ve"){
                        
                        $verfifiziert=$mapper->getVerifiziert($request->getPost('username'));
                        
                       
                        
                    }
                   
                    $user=array("Name"=>$request->getPost('username'),
                                "Passwort"=>$request->getPost('password'),
                                "Rolle"=>$Rolle,
                                "Loginstatus"=>"LogedIN",
                                 "verifiziert"=>$verfifiziert
                                
           
                    );
                    
            
                    
                  
                    
                    // Storage wird beschrieben mit dem User Array 
                    $this->getAuthService()->getStorage()->write($user);
                    
                    
                    
                    // hier fehlt noch das einspeichern der Benutzerrolle!!!
                    // Diese Benutzerrolle muss dann ausgelesen werden um das Men� benutzerdefiniert aufbauen zu k�nnen
                    
                
                    
                }
            }
        }
        
        return $this->redirect()->toRoute($redirect);
    }

    public function logoutAction()
    {
        if ($this->getAuthService()->hasIdentity()) {
            $this->getSessionStorage()->forgetMe();
            $this->getAuthService()->clearIdentity();
            $this->flashmessenger()->addMessage("You've been logged out");
        }

        return $this->redirect()->toRoute('login');
    }
    
    
 public function getLoginMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LoginMapper');
    }
}
