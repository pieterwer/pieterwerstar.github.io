<?php 

namespace Gutscheincode;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Gutscheincode\Model\Gutscheincode;
use Gutscheincode\Model\GutscheincodeTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


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
                'Gutscheincode\Model\GutscheincodeTable' =>  function($sm) {
                    $tableGateway = $sm->get('GutscheincodeTableGateway');
                    $table = new GutscheincodeTable($tableGateway);
                    return $table;
                },
                'GutscheincodeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Gutscheincode());
                    return new TableGateway('gutscheincode', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
}