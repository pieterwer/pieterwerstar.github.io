<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Search for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Search\Form\SearchForm;

class SearchController extends AbstractActionController
{
    protected $athletTable;
    protected $anschriftTable;

    public function indexAction()
    {

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new SearchForm($dbAdapter);
        $mapper = $this->getEventMapper();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $suchname = $form->getData();
                $suchname['name'] = trim($suchname['name']);
                $form->setData($suchname);
                $events = $mapper->searchAll($suchname['name']);
            } else {
                $events = $mapper->searchAll();
            }
        } else {
            $events = array();
        }
        return array(
            'form' => $form,
            'events' => $events
        );
    }

    public function veranstaltungAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new SearchForm($dbAdapter);
        $mapper = $this->getVeranstaltungMapper();
        $request = $this->getRequest();
        $veranstaltungen = array();
        $events = array();
        $counter = 0;
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $suchname = $form->getData();
                $suchname['name'] = trim($suchname['name']);
                $form->setData($suchname);
                $veranstaltungen = $mapper->searchAll($suchname['name']);
                $mapper = $this->getEventMapper();
            }
        }
        return array(
            'form' => $form,
            'veranstaltungen' => $veranstaltungen,
//             'events' => $events,
            'eventmapper' => $mapper
        );
    }
    
//     public function umkreisAction()
//     {
//         require_once ("ogdbPLZnearby.lib.php");
        
//         $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//         $form = new SearchForm($dbAdapter);
//         $mapper = $this->getEventMapper();
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $form->setData($request->getPost());
//             if ($form->isValid()) {
//                 // $suchname = $form->getData();
//                 // $suchname['name'] = trim($suchname['name']);
//                 // $form->setData($suchname);
//                 $events = $mapper->searchPlz(ogdbPLZnearby($request->getPost('postleitzahl'), $request->getPost('umkreis')));
//                 print_r(ogdbPLZnearby($request->getPost('postleitzahl'), $request->getPost('umkreis')));
//             }
//         } else {
//             $events = $mapper->searchAll();
//         }
        
//         return array(
//             'form' => $form,
//             'events' => $events
//         );
//     }

    public function erweitertAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new SearchForm($dbAdapter);
        $mapper = $this->getEventMapper();
        $request = $this->getRequest();
        $events = NULL;
//         $session = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
//         print_r($session);
//         if($session!=null && $session['Rolle'] == 'at'){
//             $athlet = $this->getAthletTable()->getAthletEmail($session['Name']);
//             print_r($athlet);
//             //der scheiss liefter mir ein athletenobjekt und kein anschriftsobjekt
//             $athletanschrift = $this->getAnschriftTable()->getAnschrift('4');
//             $anschrift = $this->getAnschriftTable()->getAnschrift(4);
//             print_r($athletanschrift);
//             print_r($anschrift);
//             if($athletanschrift->Postleitzahl!=Null){
//             $form->setData(array('umkreis'=>$athlet->Umkreis,'postleitzahl'=>$athletanschrift->Postleitzahl));
//             }
//         }
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $where = null;
                
                if ($request->getPost('name')) {
                    $suchname = $form->getData();
                    $suchname['name'] = trim($suchname['name']);
                    $form->setData($suchname);
                    $where .= 'Name like '. "'" . '%'. $suchname['name'] .'%'. "'";
                    echo $where;
                }
                
                if ($request->getPost('postleitzahl')) {
                    require_once ("ogdbPLZnearby.lib.php");
                    if($where){
                        $where .= ' AND ';
                    }
                    if($request->getPost('umkreis')){
                        $umkreis = $request->getPost('umkreis');
                    } else {
                        $umkreis = 0;
                    }
                    
                    $plz = ogdbPLZnearby($request->getPost('postleitzahl'), $umkreis);
                    $where .= '`Postleitzahl` in ('.$plz.')';
                }
                
                if ($request->getPost('kategorien')) {
                    if($where){
                        $where .= ' AND ';
                    }
                    $kategorien = '';
                    $i = 0;
                    $len = count($request->getPost('kategorien'));
                    echo $len;
                    foreach ($request->getPost('kategorien') as $kategorie) {
                        if ($i == $len - 1) {
                            $kategorien .= $kategorie;
                        } else {
                            $kategorien .= $kategorie . ',';
                        }
                        $i++;
                    }
                    $where .= '`id` in (SELECT eventid FROM `event_eventkategorie_zuordnung` where `Eventkategorieid` in (' . $kategorien . ') )';
                }
                
                if ($request->getPost('sportarten')&&$request->getPost('sportarten')!=0) {
                    if($where){
                        $where .= ' AND ';
                    }
                    $where .= '`id` in (SELECT eventid FROM `event_sportart_zuordnung` where `Sportartid` in (' . $request->getPost('sportarten') . ') )';
                }
                
                
                $events = $mapper->searchAllerweitert($where);
            }
        } else {
            $events = array();
        }
        
        return array(
            'form' => $form,
            'events' => $events
        );
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
    
    public function getAthletTable()
    {
        if (!$this->athletTable) {
            $sm = $this->getServiceLocator();
            $this->athletTable = $sm->get('Starmina\Model\AthletTable');
        }
        return $this->athletTable;
    }
    
    public function getAnschriftTable()
     {
         if (!$this->anschriftTable) {
             $sm = $this->getServiceLocator();
             $this->anschriftTable = $sm->get('Starmina\Model\AnschriftTable');
         }
         return $this->anschriftTable;
     }
    
}
