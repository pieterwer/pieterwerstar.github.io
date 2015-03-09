<?php
namespace Multiplikator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Multiplikator\Model\MultiplikatorEntity;
use Multiplikator\Form\MultiplikatorForm;

/**
 * MultiplikatorController
 *
 * @author
 *
 * @version
 *
 */
class MultiplikatorController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getMultiplikatorMapper();
        return new ViewModel(array(
            'multiplikatoren' => $mapper->fetchAll()
        ));
    }
    
    public function addAction(){
    
            $evid = (int)$this->params('id');
                 if (!$evid) {
                     return $this->redirect()->toRoute('event');
                 }
        
        $form = new MultiplikatorForm();
        $multilpikator = new MultiplikatorEntity();
        
        $form->bind($multilpikator);
        
        //Ausgabe des angelegten Users
        $user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        if($user['Rolle'] == 've')
        {  
        

            $request = $this->getRequest();
            //†berprŸft ob etwas vorhanden ist
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    
                    //Werte Ÿbernehmen
                    $multilpikator->setEventid($evid);
                    $multilpikator->setFreigegeben(0);
                    
                    //Event holen
                    $event = $this->getEventMapper()->getEvent($evid);
                    
                    //†berprŸfen ob es zu †berschneidungen kommt
                    if(!$this->getMultiplikatorMapper()->ueberschneidung($event, $request->getPost('anfang'),
                        $request->getPost('ende')))
                    {
                        echo "funktioniert";
                        return array('form' => $form, 'id' => $evid);
                    }
                    
                    //Speichern
                    $this->getMultiplikatorMapper()->saveMultiplikator($multilpikator);
            
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('multiplikator');
                }
            }
            
            return array('id' => $evid,'form' => $form);

        }
        
        return array('form' => $form, 'id' => $evid);
    }

 
   
    public function getVeranstalterMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstalterMapper');
    }
    
    // Sowas sollte man eigentlich nicht machen
    //Am besten den VeranstaltungsController einbinden und dann Ÿber diesen die Funktion aufrufen!
    public function getMultiplikatorMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('MultiplikatorMapper');
    }
    
    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }
}