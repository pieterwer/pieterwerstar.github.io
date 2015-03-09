<?php
namespace Bild\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\File\Size;
use Zend\View\Model\ViewModel;
use Bild\Model\BildEntity;
use Bild\Form\BildForm;
use Zend\Validator\File\Extension;

/**
 * BildController
 *
 * @author
 *
 * @version
 *
 */
class BildController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getBildMapper();
        return new ViewModel(array(
            'bildn' => $mapper->fetchAll(),  'dir' => dirname(__DIR__)
        ));
    }
    
public function addAction()
    {
        $form = new BildForm();
            $bild = new BildEntity();
            $form->setInputFilter($bild->getInputFilter());
        $request = $this->getRequest();
            $test = $_FILES;
        if ($request->isPost()) {
            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge($nonFile, // POST
array(
                'fileupload' => $File['name']
            )) // FILE...
;
            
            /**
             * if you're using ZF >= 2.1.1
             * you should update to the latest ZF2 version
             * and assign $data like the following
             * $data = array_merge_recursive(
             * $this->getRequest()->getPost()->toArray(),
             * $this->getRequest()->getFiles()->toArray()
             * );
             */
            
            // set data post and file ...
            $form->setData($data);
            
            if ($form->isValid()) {
                
                $size = new Size(array(
                    'max' => 2000000
                )); // maximum bytes filesize
                
                $extension = new Extension(array(
                    'extension' => 'gif,jpg,jpeg,png'
                ));
                
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                // validator can be more than one...
                $adapter->setValidators(array(
                   $extension, $size
                ), $File['name']);
//                 $adapter->addValidator('Size', false, array('max' => '200000'));
                
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    } // set formElementErrors
                    $form->setMessages(array(
                        'fileupload' => $error
                    ));
                } else {
                    $bild->exchangeArray($data);
                    $bild->setLink($File['name']);
                    $this->getBildMapper()->saveBild($bild);
                    switch($File['type']){
                        case 'image/jpeg' : $type = '.jpeg';
                            break;
                        case 'image/png' : $type = '.png';
                            break;
                        case 'image/gif' : $type = '.gif';
                            break;
                    }
                    $dateiname = $bild->getId() . $type;
                    $filter = new \Zend\Filter\File\RenameUpload(array(
                    "target"    => "./public/img/".$dateiname,
//                      "randomize" => true,
                    "overwrite" => true,
                    ));
//                     $filter->setUseUploadExtension(true);
                    
                    $filter->filter($File);
                    
                        $bild->setLink($dateiname);
                        $this->getBildMapper()->saveBild($bild);
                }
            }
        }
        
        return array(
            'form' => $form, 'test' => $test
        );
    }
    
    public function artikelbildAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('shop');
        }
        
        $form = new BildForm();
        $bild = new BildEntity();
        $form->setInputFilter($bild->getInputFilter());
        $request = $this->getRequest();
        $test = $_FILES;
        if ($request->isPost()) {
            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge($nonFile, // POST
                array(
                    'fileupload' => $File['name']
                )) // FILE...
                ;
    
            /**
             * if you're using ZF >= 2.1.1
             * you should update to the latest ZF2 version
             * and assign $data like the following
             * $data = array_merge_recursive(
             * $this->getRequest()->getPost()->toArray(),
             * $this->getRequest()->getFiles()->toArray()
             * );
            */
    
            // set data post and file ...
            $form->setData($data);
    
            if ($form->isValid()) {
    
                $size = new Size(array(
                    'max' => 2000000
                )); // maximum bytes filesize
    
                $extension = new Extension(array(
                    'extension' => 'gif,jpg,jpeg,png'
                ));
    
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                // validator can be more than one...
                $adapter->setValidators(array(
                    $extension, $size
                ), $File['name']);
                //                 $adapter->addValidator('Size', false, array('max' => '200000'));
    
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    } // set formElementErrors
                    $form->setMessages(array(
                        'fileupload' => $error
                    ));
                } else {
                    $bild->exchangeArray($data);
                    $bild->setLink($File['name']);
                    $this->getBildMapper()->saveBild($bild);
                    switch($File['type']){
                        case 'image/jpeg' : $type = '.jpeg';
                        break;
                        case 'image/png' : $type = '.png';
                        break;
                        case 'image/gif' : $type = '.gif';
                        break;
                    }
                    $dateiname = $bild->getId() . $type;
                    $filter = new \Zend\Filter\File\RenameUpload(array(
                        "target"    => "./public/img/".$dateiname,
                        //                      "randomize" => true,
                        "overwrite" => true,
                    ));
                    //                     $filter->setUseUploadExtension(true);
    
                    $filter->filter($File);
    
                    $bild->setLink($dateiname);
                    $this->getBildMapper()->saveBild($bild);
                    
                    //Speichern der Bildid in Shop artikelbildid
                    $this->getShopMapper()->artikelbild($id, $bild->getId());
                    
                }
            }
        }
    
        return array(
            'form' => $form, 'test' => $test, 'id' => $id
        );
    }
    
    public function veranstaltungAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstaltung');
        }
    
        $form = new BildForm();
        $bild = new BildEntity();
        $form->setInputFilter($bild->getInputFilter());
        $request = $this->getRequest();
        $test = $_FILES;
        if ($request->isPost()) {
            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge($nonFile, // POST
                array(
                    'fileupload' => $File['name']
                )) // FILE...
                ;
    
            /**
             * if you're using ZF >= 2.1.1
             * you should update to the latest ZF2 version
             * and assign $data like the following
             * $data = array_merge_recursive(
             * $this->getRequest()->getPost()->toArray(),
             * $this->getRequest()->getFiles()->toArray()
             * );
            */
    
            // set data post and file ...
            $form->setData($data);
    
            if ($form->isValid()) {
    
                $size = new Size(array(
                    'max' => 2000000
                )); // maximum bytes filesize
    
                $extension = new Extension(array(
                    'extension' => 'gif,jpg,jpeg,png'
                ));
    
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                // validator can be more than one...
                $adapter->setValidators(array(
                    $extension, $size
                ), $File['name']);
                //                 $adapter->addValidator('Size', false, array('max' => '200000'));
    
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    } // set formElementErrors
                    $form->setMessages(array(
                        'fileupload' => $error
                    ));
                } else {
                    $bild->exchangeArray($data);
                    $bild->setLink($File['name']);
                    $this->getBildMapper()->saveBild($bild);
                    switch($File['type']){
                        case 'image/jpeg' : $type = '.jpeg';
                        break;
                        case 'image/png' : $type = '.png';
                        break;
                        case 'image/gif' : $type = '.gif';
                        break;
                    }
                    $dateiname = $bild->getId() . $type;
                    $filter = new \Zend\Filter\File\RenameUpload(array(
                        "target"    => "./public/img/".$dateiname,
                        //                      "randomize" => true,
                        "overwrite" => true,
                    ));
                    //                     $filter->setUseUploadExtension(true);
    
                    $filter->filter($File);
    
                    $bild->setLink($dateiname);
                    $this->getBildMapper()->saveBild($bild);
    
                    //Speichern der Bildid in Shop artikelbildid
                    $this->getVeranstaltungMapper()->veranstaltungbild($id, $bild->getId());
    
                }
            }
        }
    
        return array(
            'form' => $form, 'test' => $test, 'id' => $id
        );
    }
    
    public function eventAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('veranstaltung');
        }
    
        $form = new BildForm();
        $bild = new BildEntity();
        $form->setInputFilter($bild->getInputFilter());
        $request = $this->getRequest();
        $test = $_FILES;
        if ($request->isPost()) {
            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge($nonFile, // POST
                array(
                    'fileupload' => $File['name']
                )) // FILE...
                ;
    
            /**
             * if you're using ZF >= 2.1.1
             * you should update to the latest ZF2 version
             * and assign $data like the following
             * $data = array_merge_recursive(
             * $this->getRequest()->getPost()->toArray(),
             * $this->getRequest()->getFiles()->toArray()
             * );
            */
    
            // set data post and file ...
            $form->setData($data);
    
            if ($form->isValid()) {
    
                $size = new Size(array(
                    'max' => 2000000
                )); // maximum bytes filesize
    
                $extension = new Extension(array(
                    'extension' => 'gif,jpg,jpeg,png'
                ));
    
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                // validator can be more than one...
                $adapter->setValidators(array(
                    $extension, $size
                ), $File['name']);
                //                 $adapter->addValidator('Size', false, array('max' => '200000'));
    
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    } // set formElementErrors
                    $form->setMessages(array(
                        'fileupload' => $error
                    ));
                } else {
                    $bild->exchangeArray($data);
                    $bild->setLink($File['name']);
                    $this->getBildMapper()->saveBild($bild);
                    switch($File['type']){
                        case 'image/jpeg' : $type = '.jpeg';
                        break;
                        case 'image/png' : $type = '.png';
                        break;
                        case 'image/gif' : $type = '.gif';
                        break;
                    }
                    $dateiname = $bild->getId() . $type;
                    $filter = new \Zend\Filter\File\RenameUpload(array(
                        "target"    => "./public/img/".$dateiname,
                        //                      "randomize" => true,
                        "overwrite" => true,
                    ));
                    //                     $filter->setUseUploadExtension(true);
    
                    $filter->filter($File);
    
                    $bild->setLink($dateiname);
                    $this->getBildMapper()->saveBild($bild);
    
                    //Speichern der Bildid in Shop artikelbildid
                    $this->getEventMapper()->eventbild($id, $bild->getId());
    
                }
            }
        }
    
        return array(
            'form' => $form, 'test' => $test, 'id' => $id
        );
    }
    
    public function getBildMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('BildMapper');
    }
    
    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }
    
    // Sowas sollte man eigentlich nicht machen
    // Am besten den VeranstaltungsController einbinden und dann Ÿber diesen die Funktion aufrufen!
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
    }
    
    public function getShopMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ShopMapper');
    }
}