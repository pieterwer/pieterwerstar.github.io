<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\LoginEntity;
use Login\Form\LoginForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\InputFilter\Factory;

/**
 * LoginController
 *
 * @author
 *
 * @version
 *
 */
class LoginController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {   
        
        $mapper = $this->getLoginMapper();
        $useremail = $_REQUEST['email'];
        $passwort = $_REQUEST['passwort'];
        
       
        
        $request = $this->getRequest();
       
        if ($this->getRequest()) {
            
            
            echo "es ist etwas gepostet";
            
            
            
        } else{
            echo "es ist nichts gepostet";
        }
            
         // Überprüfung ob Eingaben auch korrekt sind
             $email = new Input('email');
          $email->getValidatorChain()
          ->attach(new Validator\EmailAddress());
        
          $password = new Input('passwort');
          $password->getValidatorChain()
          
          //Länge muss noch angepasst werden-> min=8 max=16
          ->attach(new Validator\StringLength(array('min'=>8,'max' => 16)));
        
          $inputFilter = new InputFilter();
        $inputFilter->add($email)
           ->add($password)
        ->setData($_GET);
        
        if ($inputFilter->isValid()) {
            echo "The form is valid\n";
            // Hier fehlt noch der Check + die SetData Action wenn man sich einloggt
            
            
            
            
        } else {
            // Hier fehlt eine redirect route zurück zur login form
            echo "The form is not valid\n";
            foreach ($inputFilter->getInvalidInput() as $error) {
                print_r($error->getMessages());
            }
           
            
           
        }
        
        
        
        
        
        
        echo $useremail;
        echo $passwort;
        if(($useremail!="")||($passwort!="")){
           
           
            
            $check=$mapper->checkLogin($useremail,$passwort);
            echo $check;
            if($check==FALSE){
                // bei Falschem Login fehlt noch eine Ausgabe in der index.phtml
                
                echo "login nicht gefunden";
            }
        if($check==true){
            //
                $loginentity=$mapper->setLoginData($useremail,$passwort);
                echo "logindaten korrekt!!";
                
                $Rolle=$loginentity->getRolle();
                echo $Rolle;
                
                //if($Rolle=="ve"){
                    
                    //beispielsweise der redirect 
                   // return $this->redirect()->toRoute('veranstalter'); }
               //($Rolle=="AB"){
                
                    //beispielsweise der redirect
                  //  return $this->redirect()->toRoute('werbeauftrag');
               // }
                
        }
        }
        
       
        
        return new ViewModel();
    }
    
    
    
    public function loginAction()
    {
        
        
       
        
    }
    
    
    public function getLoginMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('LoginMapper');
    }
}