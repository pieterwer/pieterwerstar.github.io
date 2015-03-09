<?php
 namespace Starmina;

 use Starmina\Model\Athlet;
 use Starmina\Model\AthletTable;
 use Starmina\Model\Verein;
 use Starmina\Model\VereinTable;
 use Starmina\Model\LogindatenTable;
 use Starmina\Model\Anschrift;
 use Starmina\Model\AnschriftTable;
 use Starmina\Model\Motivation;
 use Starmina\Model\MotivationTable;
 use Starmina\Model\Gutscheincode;
 use Starmina\Model\VereinBuchungTable;
 use Starmina\Model\GutscheincodeTable;
  use Starmina\Model\AthletenGuthaben;
 use Starmina\Model\AthletenGuthabenTable;
 use Starmina\Model\Bild;
 use Starmina\Model\BildTable;
 use Starmina\Model\MotivationZuordnung;
 use Starmina\Model\MotivationZuordnungTable;
 use Starmina\Model\SportartZuordnung;
 use Starmina\Model\SportartZuordnungTable;
 use Starmina\Model\VeranstaltungEntity;
 use Starmina\Model\VeranstaltungMapper;
 use Starmina\Model\VeranstalterEntity;
 use Starmina\Model\VeranstalterMapper;
 use Starmina\Model\ErgebnisEntity;
 use Starmina\Model\ErgebnisMapper;
 use Starmina\Model\AthletenbezahlungMapper;
use Starmina\Controller\AthletenbezahlungController;
 use Starmina\Model\EventMapper;
use Starmina\Model\EventsportartMapper;
use Starmina\Model\SportartMapper;
use Starmina\Model\EventkategorieMapper;
use Starmina\Model\KategorieMapper;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Stdlib\ArrayObject;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Starmina\Model\LoginMapper;
use Starmina\Model\UserMapper;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Starmina\Model\Logindaten;
	 

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
	 
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
 

     public function getServiceConfig()
     {
            
		
         return array(
             'factories' => array(
                 'Starmina\Model\AthletTable' =>  function($sm) {
                     $tableGateway = $sm->get('AthletTableGateway');
                     $table = new AthletTable($tableGateway);
                     return $table;
                 },
				 
				 
				 'Starmina\Model\VereinTable' =>  function($sm) {
                     $tableGateway = $sm->get('VereinTableGateway');
                     $table = new VereinTable($tableGateway);
                     return $table;
				 },
				 
				 'Starmina\Model\LogindatenTable' =>  function($sm) {
                     $tableGateway = $sm->get('LogindatenTableGateway');
                     $table = new LogindatenTable($tableGateway);
                     return $table;
                 },
				 
				 'Starmina\Model\AnschriftTable' =>  function($sm) {
                     $tableGateway = $sm->get('AnschriftTableGateway');
                     $table = new AnschriftTable($tableGateway);
                     return $table;
                 },
                 'Starmina\Model\VereinBuchungTable' =>  function($sm) {
                 	$tableGateway = $sm->get('VereinBuchungTableGateway');
                 	$table = new VereinBuchungTable($tableGateway);
                 	return $table;
                 },
				 
				  
				 'Starmina\Model\MotivationZuordnungTable' =>  function($sm) {
                     $tableGateway = $sm->get('MotivationZuordnungTableGateway');
                     $table = new MotivationZuordnungTable($tableGateway);
                     return $table;
                 },
				 
				 'Starmina\Model\SportartZuordnungTable' =>  function($sm) {
                     $tableGateway = $sm->get('SportartZuordnungTableGateway');
                     $table = new SportartZuordnungTable($tableGateway);
                     return $table;
                 },
				 
				 'Starmina\Model\BildTable' =>  function($sm) {
                     $tableGateway = $sm->get('BildTableGateway');
                     $table = new BildTable($tableGateway);
                     return $table;
                 },
				 
				 'Starmina\Model\GutscheincodeTable' =>  function($sm) {
                     $tableGateway = $sm->get('GutscheincodeTableGateway');
                     $table = new GutscheincodeTable($tableGateway);
                     return $table;
                 },
					 
				
				'Starmina\Model\AthletenGuthabenTable' =>  function($sm) {
                     $tableGateway = $sm->get('AthletenGuthabenTableGateway');
                     $table = new AthletenGuthabenTable($tableGateway);
                     return $table;
                 },
				 	 
                 'AthletTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Athlet());
                     return new TableGateway('athlet', $dbAdapter, null, $resultSetPrototype);
				 },
				 'VereinBuchungTableGateway' => function ($sm) {
				 	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				 	$resultSetPrototype = new ResultSet();
				 	$resultSetPrototype->setArrayObjectPrototype(new Athlet());
				 	return new TableGateway('verein_buchung', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'VereinTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Verein());
                     return new TableGateway('verein', $dbAdapter, null, $resultSetPrototype);
                 },
				 
				 	 
                 'LogindatenTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Logindaten());
                     return new TableGateway('logindaten', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'AnschriftTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Anschrift());
                     return new TableGateway('athletenanschrift', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'MotivationZuordnungTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new MotivationZuordnung());
                     return new TableGateway('athlet_motivation_zuordnung', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'SportartZuordnungTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new SportartZuordnung());
                     return new TableGateway('athlet_sportart_zuordnung', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'BildTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Bild());
                     return new TableGateway('bild', $dbAdapter, null, $resultSetPrototype);
				 },
				 'GutscheincodeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Gutscheincode());
                     return new TableGateway('gutscheincode', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'AthletenGuthabenTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new AthletenGuthaben());
                     return new TableGateway('athlet_guthaben_konto', $dbAdapter, null, $resultSetPrototype);
				 },
				 
				 'VeranstaltungMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new VeranstaltungMapper($dbAdapter);
                    return $mapper;
                },
				'EventMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new EventMapper($dbAdapter);
                    return $mapper;
                },
                'EventsportartMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new EventsportartMapper($dbAdapter);
                    return $mapper;
                },
                'SportartMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new SportartMapper($dbAdapter);
                    return $mapper;
                },
                'EventkategorieMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new EventkategorieMapper($dbAdapter);
                    return $mapper;
                },
                'KategorieMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new KategorieMapper($dbAdapter);
                    return $mapper;
                },
				'AthletenbezahlungMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new AthletenbezahlungMapper($dbAdapter);
                    return $mapper;
                },
				'ErgebnisMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new ErgebnisMapper($dbAdapter);
                    return $mapper;
                },
				 'LoginMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new LoginMapper($dbAdapter);
                    return $mapper;
                },
                
                'UserMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new UserMapper();
                    return $mapper;
                },
				 'VeranstalterMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new VeranstalterMapper($dbAdapter);
                    return $mapper;
                },
                

        'Starmina\Model\MyAuthStorage' => function ($sm) {
            return new \Starmina\Model\MyAuthStorage('zf_tutorial');
        },

        'AuthService' => function ($sm) {
            $dbAdapter      = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'logindaten','Email','Passwort');

            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $authService->setStorage($sm->get('Starmina\Model\MyAuthStorage'));

            return $authService;
        },
             ),
         );
     }
	 public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
    }
	 
 }