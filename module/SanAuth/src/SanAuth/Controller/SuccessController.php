<?php

namespace SanAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class SuccessController extends AbstractActionController
{
    public function indexAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            
            return $this->redirect()->toRoute('login');
            
        }
       
        //echo "da ist der eingeloggte Benutzer:   ";
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        //var_dump($user);
        
        return new ViewModel();
    }
    
    
    public function printAction()
    {
        
        //echo "da ist der eingeloggte Benutzer:   ";
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        
        
        return $user;
    }
}
