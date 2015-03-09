<?php
namespace Ergebnis\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ergebnis\Model\ErgebnisEntity;
use Ergebnis\Form\ErgebnisForm;
use Ergebnis\Form\UploadForm;
use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\File\Size;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Validator\File\Extension;

/**
 * ErgebnisController
 *
 * @author
 *
 * @version
 *
 */
class ErgebnisController extends AbstractActionController
{

    protected $athletTable;

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $mapper = $this->getErgebnisMapper();
        
        //Athleten"Mapper"
        $athlet = $this->getAthletTable();
        
        //Event-Mapper
        $event = $this->getEventMapper();
        
        return new ViewModel(array(
            'ergebnisse' => $mapper->fetchAll(), 'athlet' => $athlet, 'event' => $event
        ));
    }

    public function showAction()
    {
        $verid = (int) $this->params('id');
        if (! $verid) {
            return $this->redirect()->toRoute('Bild');
        }
        $Bild = $this->getBildMapper()->getBild($verid);
        $veranstaltungen = $this->getVeranstaltungMapper()->Veranstaltungver($verid);
        if (! $veranstaltungen) {
            return $this->redirect()->toRoute('veranstaltung');
        }
        
        // $event = $this->getEventMapper()->getEvent($id);
        // $date = date_create($event->getDatum());
        // $event->setDatum (date_format($date,'Y-m-d H:i'));
        
        return new ViewModel(array(
            'veranstaltung' => $veranstaltungen,
            'Bild' => $Bild
        ));
    }

    public function addAction()
    {
        $form = new ErgebnisForm();
        $ergebnis = new ErgebnisEntity();
        
        $form->bind($ergebnis);
        
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
//         echo $athlet->geburtstag_athlet;
        
        // die †bergabe von Werten funktioniert noch nicht
        $request = $this->getRequest();
        // †berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
//                 echo "Hallo";
                // †berprŸfen ob Teilnehmerlimit Ÿberschritten wurde
                $anzahl = $this->getErgebnisMapper()->checkAnzahl($request->getPost('eventid'));
                $event = $this->getEventMapper()->getEvent($request->getPost('eventid'));
                if ($anzahl >= $event->getTeilnehmerlimit()) {
                    echo "†berschritten!!!";
                    $this->flashMessenger()->addMessage('Teilnehmerlimit wurde bereits erreicht');
                }
                else {
                /*    
                //†berprŸfen ob sich der Athlet anhand seines Guthabens Ÿberhaupt die Teilnahme leisten kann
                
                if($this->getErgebnisMapper()->getGuthaben($athlet) < $event->getAnmeldegebuehr())
                {
                    echo"Zu wenig Kohle";
                    $this->flashMessenger()->addMessage('Teilnehmerlimit wurde bereits erreicht');
                }
                */    
              
                //Bevor gespeichert wird mŸssen wir noch das Alter auslesen!
                $geburtstag = $athlet->geburtstag;
                $ergebnis->setAthletid($athlet->id);
             
                //Speichern der Teilnahme
                $this->getErgebnisMapper()->saveErgebnis($ergebnis, $geburtstag);
                
                //Erstellen einer Buchunng vom Athletenkonte
                $this->getErgebnisMapper()->kostenpflichtig($athlet, $event);
                
                //Updaten der Platzierung fŸr dieses Event
                $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($request->getPost('eventid'), $sort = 0);
                $this->getErgebnisMapper()->updatePlatzierung($ergebnisse);
                
                //Redirect to list of tasks
                return $this->redirect()->toRoute('ergebnis');
                }
                
            }
        }
        
        return array(
            'form' => $form
        );
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (! $id) {
            return $this->redirect()->toRoute('Bild', array(
                'action' => 'add'
            ));
        }
        $Bild = $this->getBildMapper()->getBild($id);
        
        $form = new BildForm();
        $form->bind($Bild);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getBildMapper()->saveBild($Bild);
                
                return $this->redirect()->toRoute('Bild');
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form
        );
    }

    public function exportAction()
    {
        /**
         * PHPExcel
         *
         * Copyright (C) 2006 - 2014 PHPExcel
         *
         * This library is free software; you can redistribute it and/or
         * modify it under the terms of the GNU Lesser General Public
         * License as published by the Free Software Foundation; either
         * version 2.1 of the License, or (at your option) any later version.
         *
         * This library is distributed in the hope that it will be useful,
         * but WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
         * Lesser General Public License for more details.
         *
         * You should have received a copy of the GNU Lesser General Public
         * License along with this library; if not, write to the Free Software
         * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
         *
         * @category PHPExcel
         * @package PHPExcel
         * @copyright Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
         * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
         * @version ##VERSION##, ##DATE##
         */
        /**
         * Error reporting
         */
        error_reporting(0);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        /**
         * Include PHPExcel
         */
            // require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
        
        $id = $this->params('id');
        
        $event = $this->getEventMapper()->getEvent($id);
        if ($event == null) {
            exit();
        }
        $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($id);
        $veranstaltung = $this->getVeranstaltungMapper()->getVeranstaltung($event->getVeranstaltungsid());
        if ($veranstaltung == null) {
            exit();
        }
        
        $user = $this->getServiceLocator()
        ->get('AuthService')
        ->getStorage()
        ->read();
        //         var_dump($user);
        //         echo "<br>";
        //         echo $user['Name'];
        //         echo $user['Rolle'];
        
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator("Starmina")
            ->setLastModifiedBy("Starmina")
            ->setTitle("Liste" . $event->getId())
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        // // Add some data
        if($user == null || $user['Rolle']=='at'){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Veranstaltung:')
            ->setCellValue('B1', $veranstaltung->getName())
            ->setCellValue('A2', 'Event:')
            ->setCellValue('B2', $event->getName())
            ->setCellValue('A4', 'Nachname:')
            ->setCellValue('B4', 'Vorname:')
            ->setCellValue('C4', 'Zeit:');
        
        $i = 5;
        
        foreach ($ergebnisse as $ergebnis) {
            $athlet = $this->getAthletTable()->getAthlet($ergebnis->getAthletid());
            if($ergebnis->getZeit() == (float) 10000000){ $zeit = ''; } else { $zeit = $ergebnis->getZeit();}
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C' . $i, $zeit)
                ->setCellValue('A' . $i, $athlet->Name)
                ->setCellValue('B' . $i, $athlet->Vorname);
            $i ++;
        }
        } else {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Veranstaltung:')
            ->setCellValue('B1', $veranstaltung->getName())
            ->setCellValue('D1', $veranstaltung->getId())
            ->setCellValue('A2', 'Event:')
            ->setCellValue('B2', $event->getName())
            ->setCellValue('D2', $event->getId())
            ->setCellValue('A4', 'Nachname:')
            ->setCellValue('B4', 'Vorname:')
            ->setCellValue('C4', 'Zeit:');
            
            $i = 5;
            
            foreach ($ergebnisse as $ergebnis) {
                $athlet = $this->getAthletTable()->getAthlet($ergebnis->getAthletid());
                if($ergebnis->getZeit() == (float) 10000000){ $zeit = ''; } else { $zeit = $ergebnis->getZeit();}
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C' . $i, $zeit)
                ->setCellValue('A' . $i, $athlet->Name)
                ->setCellValue('D' . $i, $athlet->id)
                ->setCellValue('B' . $i, $athlet->Vorname);
                $i ++;
            }
        }
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Liste' . $event->getId());
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Liste' . $event->getId() . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        error_reporting(E_ALL);
        exit();
        
    }

    public function importAction()
    {
        $form = new UploadForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            // $form->setInputFilter($profile->getInputFilter());
            
            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('fileupload');
            $data = array_merge($nonFile, array(
                'fileupload' => $File['name']
            ));
            // set data post and file ...
            $form->setData($data);
            
            if ($form->isValid()) {
                
                $size = new Size(array(
                    'max' => 2000000
                ));
                
                $extension = new Extension(array(
                    'extension' => 'xls'
                ));
                
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array(
                    $size, $extension
                ), $File['name']);
                if (! $adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array(
                        'fileupload' => $error
                    ));
                } else {
                    $ergebnis = new ErgebnisEntity();
                    $adapter->setDestination("./");
                    if ($adapter->receive($File['name'])) {
                        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                        $objPHPExcel = \PHPExcel_IOFactory::load($File['name']);
                        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                            $ergebnis->setEventid($worksheet->getCellByColumnAndRow(3, 2)
                                ->getValue());
                            $verify = $dbAdapter->query('SELECT `id` FROM `event` WHERE `Name` = ? and id = ? and `Veranstaltungsid` in (select id from veranstaltung where id = (select id from veranstaltung where name = ? and id = ?))', 
                                array($worksheet->getCellByColumnAndRow(1,2)->getValue(),$ergebnis->getEventid(),$worksheet->getCellByColumnAndRow(1,1)->getValue(),$worksheet->getCellByColumnAndRow(3,1)->getValue()));
                            $test = $verify->toArray();
                            if($test[0]['id']!= $ergebnis->getEventid() || $verify->count()!=1){
                                //oder andere weiterleitung bzw meldung hinzufügen und ob das event schon statt fand und , mit . ersetzen
                                return $this->redirect()->toRoute('ergebnis',array('action'=>'import'));
                            }
                            $worksheetTitle = $worksheet->getTitle();
                            $highestRow = $worksheet->getHighestRow();
                            $highestColumn = $worksheet->getHighestColumn();
                            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                            for ($row = 5; $row <= $highestRow; ++ $row) {
                                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                    $val = $cell->getValue();
                                    $dataType = \PHPExcel_Cell_DataType::dataTypeForValue($val);
                                    
                                    if ($col == 2) {
                                        
                                        if(!is_float($val)){
                                            $ergebnis->setZeit('');
                                        } else {
                                        $ergebnis->setZeit($val);
                                        }
                                    }
                                    if ($col == 3) {
                                        $ergebnis->setAthletid($val);
                                    }
                                }
                                $this->getErgebnisMapper()->updateTime($ergebnis);
                                $action2 = $dbAdapter->query('UPDATE `ergebnis` SET `Alter`=TIMESTAMPDIFF(YEAR,(select Geburtstag from athlet where id = ?),(select Datum from event where id = ?)) WHERE `Eventid` = ? AND `Athletid` = ?', array($ergebnis->getAthletid(), $ergebnis->getEventid(), $ergebnis->getEventid(), $ergebnis->getAthletid()));
                            }
                            $this->getErgebnisMapper()->updatePlatzierung($this->getErgebnisMapper()->Ergebnisev($ergebnis->getEventid()));
                            unlink($File['name']);
                        }
                        return $this->redirect()->toRoute('ergebnis',array('action'=>'ergebnis','id'=> $ergebnis->getEventid()));
                    }
                }
            }
        }
        
        return array(
            'form' => $form
        );
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $Bild = $this->getBildMapper()->getBild($id);
        if (! $Bild) {
            return $this->redirect()->toRoute('Bild');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getBildMapper()->deleteBild($id);
                $this->getBildMapper()->deleteLogin($Bild);
            }
            
            return $this->redirect()->toRoute('Bild');
        }
        
        return array(
            'id' => $id,
            'Bild' => $Bild
        );
    }
	public function athletenergebnisAction()
{
$user=$this->getServiceLocator()->get('AuthService')->getStorage()->read();          
$athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']); 	 
$athletid = $athlet->id;          
 $mapper = $this->getErgebnisMapper();         
 return new ViewModel(array(      'ergebnisse' => $mapper->athletfetchAll($athletid)         ));     
}


    public function ergebnisAction()
    {
        $evid = (int) $this->params('id');
        // if (!$evid) {
        // return $this->redirect()->toRoute('event');
        // }
        // $sort = (int)$this->params('srt');
        
        // Test
        $form = new ErgebnisForm();
        $ergebnis = new ErgebnisEntity();
        
        // Wenn keine Filterung ausgewŠhlt wurde
        $sort = 0;
        
        $form->bind($ergebnis);
        $request = $this->getRequest();
        // †berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $sort = $request->getPost('srt');
//             echo "Hallo";
            $form->setData($request->getPost());
            if ($form->isValid()) {
                echo "Formular";
            }
        }
//         echo $this->params('srt');
        $event = $this->getEventMapper()->getEvent($evid);
        if (! $event) {
            return $this->redirect()->toRoute('event', array(
                'action' => 'show'
            ));
        }
        // hier muss dann die Where bedingung Ÿbergeben werden
        // 14.12.2014 Athlet-Modul noch nicht Ÿbergeben + Berechnung des Alters muss umgesetzt werden
        
        $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($event->getId(), $sort);
//         print_r($ergebnisse);
        if (! $ergebnisse) {
            return $this->redirect()->toRoute('ergebnis');
        }
        
        // $event = $this->getEventMapper()->getEvent($id);
        // $date = date_create($event->getDatum());
        // $event->setDatum (date_format($date,'Y-m-d H:i'));
        //Athleten"Mapper"
        $athlet = $this->getAthletTable();
        
        return new ViewModel(array(
            'ergebnisse' => $ergebnisse,
            'event' => $event,
            'athlet' => $athlet,
            'form' => $form
        ));
    }

    public function teilnehmerAction()
    {
        $evid = (int) $this->params('id');
        // if (!$evid) {
        // return $this->redirect()->toRoute('event');
        // }
        // $sort = (int)$this->params('srt');
    
        // Test
        $form = new ErgebnisForm();
        $ergebnis = new ErgebnisEntity();
    
        // Wenn keine Filterung ausgewŠhlt wurde
        $sort = 0;
    
        $form->bind($ergebnis);
        $request = $this->getRequest();
        // †berprŸft ob etwas vorhanden ist
        if ($request->isPost()) {
            $sort = $request->getPost('srt');
            //             echo "Hallo";
            $form->setData($request->getPost());
            if ($form->isValid()) {
                echo "Formular";
            }
        }
        //         echo $this->params('srt');
        $event = $this->getEventMapper()->getEvent($evid);
        if (! $event) {
            return $this->redirect()->toRoute('event', array(
                'action' => 'show'
            ));
        }
        // hier muss dann die Where bedingung Ÿbergeben werden
        // 14.12.2014 Athlet-Modul noch nicht Ÿbergeben + Berechnung des Alters muss umgesetzt werden
    
        $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($event->getId(), $sort);
        //         print_r($ergebnisse);
        if (! $ergebnisse) {
            return $this->redirect()->toRoute('ergebnis');
        }
    
        // $event = $this->getEventMapper()->getEvent($id);
        // $date = date_create($event->getDatum());
        // $event->setDatum (date_format($date,'Y-m-d H:i'));
    
        return new ViewModel(array(
            'ergebnisse' => $ergebnisse,
            'event' => $event,
            'form' => $form
        ));
    }
    
    
    public function anmeldenAction()
    {
        $evid = (int) $this->params('id');
        if (! $evid) {
            return $this->redirect()->toRoute('event');
        }
        
        $form = new ErgebnisForm();
        $ergebnis = new ErgebnisEntity();
        
        $form->bind($ergebnis);
        
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        error_reporting(0);
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
        error_reporting(E_ALL);
//         echo "<br>";
//         echo $athlet->id;
        
        // †berprŸfen ob es bereits eine Anmeldung gibt
        if ($this->getErgebnisMapper()->getErgebnis($evid, $athlet->id)) {
            $this->flashMessenger()->addMessage('Sie haben sich bereits fuer dieses Event angemeldet');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
        }

 
                //†berprŸfen ob Teilnehmerlimit Ÿberschritten wurde
                $anzahl = $this->getErgebnisMapper()->checkAnzahl($evid);
                $event = $this->getEventMapper()->getEvent($evid);
                if($event->getTeilnehmerlimit()> 0 && $anzahl >= $event->getTeilnehmerlimit())
                {
//                     echo "†berschritten!!!";
                    $this->flashMessenger()->addMessage('Teilnehmerlimit wurde bereits erreicht');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                }

                //†berprŸfen ob letzte Stunde vorm Event bereits begonnen hat
//                 $time = $event->getDatum() - (60*60);
//                 date_create('-1 hour '.$time)->format('Y-m-d H-i-s');
                $date = date_create($event->getDatum());
//                 $time1 = date_format($date,'Y-m-d H-i')  - time(60*60);
                $time = $date->sub(new \DateInterval('PT01H'));
//                 print_r($time->format('Y-m-d H-i-s'));
    
//                 echo date("Y-m-d H:i:s");
                if($time->format('Y-m-d H:i:s') < date("Y-m-d H:i:s"))
                {
//                     echo "†berschritten!!!";
                    $this->flashMessenger()->addMessage('Anmeldung zum Event nicht mehr mšglich'. $time->format('Y-m-d H-i-s') .' Zeit'.date("Y-m-d H:i:s"));
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                }
                
                // die †bergabe von Werten
                $request = $this->getRequest();
                
                if ($request->isPost()) {
                    $zahlungsart = $request->getPost('zahlungsart');
                    $form->setData($request->getPost());
//                     echo "Hier";
                
//                     echo "<br>Zahlungsart:";    
//                     echo $zahlungsart;
                    
                    //†berprŸfen ob sich der Athlet anhand seines Guthabens Ÿberhaupt die Teilnahme leisten kann
                    if($zahlungsart == 1)
                    {    
                    if($this->getErgebnisMapper()->getGuthaben($athlet) < $event->getAnmeldegebuehr())
                    {
                        $this->flashMessenger()->addMessage('Sie haben zu wenig Guthaben fuer die Anmeldung zu diesem Event. Ihr Aktueller Kontostand betraegt: '. $this->getErgebnisMapper()->getGuthaben($athlet) .' Euro');
                        // Redirect to list of tasks
                        return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                    }
                    }

                    
                    //GeschlechtsprŸfung
                    if(($athlet->Geschlecht != $event->getGeschlechtsbeschraenkung()) && $event->getGeschlechtsbeschraenkung() != NULL)
                    {
                        $this->flashMessenger()->addMessage('Dieses Event ist nur fuer ein bestimmtes Geschlecht verfuegbar:  '.$event->getGeschlechtsbeschraenkung());
                        // Redirect to list of tasks
                        return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                    }
                    /*
                    //AltersŸberprŸfung
                    $geburtstag = new \DateTime(date(('Y-m-d'),$athlet->Geburstag));
                    $heute = new \DateTime(date('Y-m-d'),$event->getDatum());
                    $differenz = $geburtstag->diff($heute);
                    
                    $differenz->format('%y');
                    if(false)
                    {
                        $this->flashMessenger()->addMessage('Dieses Event ist nur fuer ein bestimmtes Geschlecht verfuegbar:  '.$differenz->format('%y'));
                        // Redirect to list of tasks
                        return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                    }
                    */
                    
                    //Bevor gespeichert wird mŸssen wir noch das Alter auslesen!
                    $geburtstag = $athlet->Geburtstag;
                    $ergebnis->setAthletid($athlet->id);
                    $ergebnis->setEventid($evid);
                    $ergebnis->setZeit(9999999.00);
                    $ergebnis->setAltersklassenplatzierung(0);
                    $ergebnis->setGesamtplatzierung(0);
                    
                    //Speichern
                    $this->getErgebnisMapper()->saveErgebnis($ergebnis, $geburtstag);
                    
                    //Erstellen der Buchung
                    if($zahlungsart == 1)
                    {
                        $this->getErgebnisMapper()->guthaben($athlet, $event);
                    }    
                    if($zahlungsart == 0)
                    {
                        $this->getErgebnisMapper()->lastschrift($athlet, $event);
                    }
                    /*
                    //Updaten der Platzierung fŸr dieses Event
                    $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($evid, $sort = 0);
                    $this->getErgebnisMapper()->updatePlatzierung($ergebnisse);
                    */
                    //Redirect to list of tasks
                    return new ViewModel(array('event' => $event));

//         }
        
//         return array('form' => $form);
                    }
    }
    
    public function abmeldenAction(){
    
        $evid = (int) $this->params('id');
        if (! $evid) {
            return $this->redirect()->toRoute('event');
        }
        
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
            ->get('AuthService')
            ->getStorage()
            ->read();
        var_dump($user);
        echo "<br>";
        echo $user['Name'];
        echo $user['Rolle'];
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);

        
        $event = $this->getEventMapper()->getEvent($evid);
        
        $date = date_create($event->getDatum());
        $time = $date->sub(new \DateInterval('P1D'));
        print_r($time->format('Y-m-d H-i-s'));
        
        echo date("Y-m-d H:i:s");
        if($time->format('Y-m-d H:i:s') < date("Y-m-d H:i:s"))
        {
            echo "†berschritten!!!";
            $this->flashMessenger()->addMessage('Das Event findet in weniger als 24h statt, daher ist eine kostenlose Abmeldung nicht mehr moeglich'. $time->format('Y-m-d H-i-s') .' Zeit'.date("Y-m-d H:i:s"));
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'show', 'id' => $event->getId()));
        }
        
                   //Anmeldung holen
                   $ergebnis = $this->getErgebnisMapper()->getErgebnis($event->getId(), $athlet->id);
                   
                   //ZurŸckbuchen
                   $this->getErgebnisMapper()->back($athlet, $event);
                   
                   //Loeschen
                   $this->getErgebnisMapper()->deleteErgebnis($event->getId(), $athlet->id);
                   
                   //Redirect to list of tasks
                   return $this->redirect()->toRoute('event', array(
                       'action' => 'show', 'id' => $evid
                   ));

    }
    

    public function kindAction()
    {
        $evid = (int) $this->params('id');
        if (! $evid) {
            return $this->redirect()->toRoute('event');
        }
        
        $kid = (int) $this->params('kid');
        if (! $kid) {
            return $this->redirect()->toRoute('kinder');
        }
    
        $form = new ErgebnisForm();
        $ergebnis = new ErgebnisEntity();
    
        $form->bind($ergebnis);
    
        // Ausgabe des angelegten Users
        $user = $this->getServiceLocator()
        ->get('AuthService')
        ->getStorage()
        ->read();
//         var_dump($user);
//         echo "<br>";
//         echo $user['Name'];
//         echo $user['Rolle'];
        $athlet = $this->getUserMapper()->getUserobject($user['Rolle'], $user['Name']);
//         echo "<br>";
//         echo $athlet->id;
        /*
        // †berprŸfen ob es bereits eine Anmeldung gibt
        if ($this->getErgebnisMapper()->getErgebnis($evid, $athlet->id)) {
            $this->flashMessenger()->addMessage('Sie haben sich bereits fuer dieses Event angemeldet');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
        }
        */
    
        
        if ($this->getErgebnisMapper()->getKindergebnis($evid, $kid)) {
            $this->flashMessenger()->addMessage('Sie haben das Kind bereits fuer dieses Event angemeldet');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
        }
        
        //†berprŸfen ob Teilnehmerlimit Ÿberschritten wurde
        $anzahl = $this->getErgebnisMapper()->checkAnzahl($evid);
        $event = $this->getEventMapper()->getEvent($evid);
        if($anzahl >= $event->getTeilnehmerlimit())
        {
//             echo "†berschritten!!!";
            $this->flashMessenger()->addMessage('Teilnehmerlimit wurde bereits erreicht');
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
        }
    
        //†berprŸfen ob letzte Stunde vorm Event bereits begonnen hat
        //                 $time = $event->getDatum() - (60*60);
        //                 date_create('-1 hour '.$time)->format('Y-m-d H-i-s');
        $date = date_create($event->getDatum());
        //                 $time1 = date_format($date,'Y-m-d H-i')  - time(60*60);
        $time = $date->sub(new \DateInterval('PT01H'));
//         print_r($time->format('Y-m-d H-i-s'));
    
//         echo date("Y-m-d H:i:s");
        if($time->format('Y-m-d H:i:s') < date("Y-m-d H:i:s"))
        {
//             echo "†berschritten!!!";
            $this->flashMessenger()->addMessage('Anmeldung zum Event nicht mehr mšglich'. $time->format('Y-m-d H-i-s') .' Zeit'.date("Y-m-d H:i:s"));
            // Redirect to list of tasks
            return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
        }
    
        // die †bergabe von Werten
        $request = $this->getRequest();
    
        if ($request->isPost()) {
            $zahlungsart = $request->getPost('zahlungsart');
            $form->setData($request->getPost());
//             echo "Hier";
    
//             echo "<br>Zahlungsart:";
//             echo $zahlungsart;
    
            //†berprŸfen ob sich der Athlet anhand seines Guthabens Ÿberhaupt die Teilnahme leisten kann
            if($zahlungsart == 1)
            {
                if($this->getErgebnisMapper()->getGuthaben($athlet) < $event->getAnmeldegebuehr())
                {
                    $this->flashMessenger()->addMessage('Sie haben zu wenig Guthaben fuer die Anmeldung zu diesem Event. Ihr Aktueller Kontostand betraegt: '. $this->getErgebnisMapper()->getGuthaben($athlet) .' Euro');
                    // Redirect to list of tasks
                    return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
                }
            }
    
    
            //GeschlechtsprŸfung
            if(($athlet->Geschlecht != $event->getGeschlechtsbeschraenkung()) && $event->getGeschlechtsbeschraenkung() != NULL)
            {
                $this->flashMessenger()->addMessage('Dieses Event ist nur fuer ein bestimmtes Geschlecht verfuegbar:  '.$event->getGeschlechtsbeschraenkung());
                // Redirect to list of tasks
                return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
            }
            /*
             //AltersŸberprŸfung
             $geburtstag = new \DateTime(date(('Y-m-d'),$athlet->Geburstag));
             $heute = new \DateTime(date('Y-m-d'),$event->getDatum());
             $differenz = $geburtstag->diff($heute);
    
             $differenz->format('%y');
             if(false)
             {
             $this->flashMessenger()->addMessage('Dieses Event ist nur fuer ein bestimmtes Geschlecht verfuegbar:  '.$differenz->format('%y'));
             // Redirect to list of tasks
             return $this->redirect()->toRoute('event', array('action' => 'aktuell'));
             }
             */
    
//             echo "<br>Event:";
//             echo $event->getId();
            
            //Speichern der Anmeldung
            $this->getErgebnisMapper()->kind($kid, $event->getId());
    
            //Erstellen der Buchung
            if($zahlungsart == 1)
            {
                $this->getErgebnisMapper()->guthaben($athlet, $event);
            }
            if($zahlungsart == 0)
            {
                $this->getErgebnisMapper()->lastschrift($athlet, $event);
            }
            /*
             //Updaten der Platzierung fŸr dieses Event
             $ergebnisse = $this->getErgebnisMapper()->Ergebnisev($evid, $sort = 0);
             $this->getErgebnisMapper()->updatePlatzierung($ergebnisse);
             */
            //Redirect to list of tasks
            return new ViewModel(array('event' => $event));
    
            //         }
    
            //         return array('form' => $form);
        }
    }
    
    
    public function getErgebnisMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ErgebnisMapper');
    }
    
    // Sowas sollte man eigentlich nicht machen
    // Am besten den VeranstaltungsController einbinden und dann Ÿber diesen die Funktion aufrufen!
    public function getVeranstaltungMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('VeranstaltungMapper');
    }

    public function getEventMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('EventMapper');
    }

    public function getUserMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserMapper');
    }

    public function getAthletTable()
    {
        if (! $this->athletTable) {
            $sm = $this->getServiceLocator();
            $this->athletTable = $sm->get('Starmina\Model\AthletTable');
        }
        return $this->athletTable;
    }
}