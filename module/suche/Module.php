<?php 
namespace Suche;

// Add these import statements:

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Suche\Model\Athlet;
use Suche\Model\AthletTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

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
                 'Suche\Model\AthletTable' =>  function($sm) {
                     $tableGateway = $sm->get('AthletTableGateway');
                     $table = new AthletTable($tableGateway);
                     return $table;
                 },
                 'AthletTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Athlet());
                     return new TableGateway('athlet', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
     
 }