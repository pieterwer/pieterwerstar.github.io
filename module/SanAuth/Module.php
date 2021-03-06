<?php

namespace SanAuth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use SanAuth\Model\LoginMapper;
use SanAuth\Model\UserMapper;


class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
            // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
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

    // setting db config immediately if necessary, ignore if already defined in global.php
    //   'db' => array(
    //	'username' => 'YOUR USERNAME HERE',
    //	'password' => 'YOUR PASSWORD HERE',
    //	'driver'         => 'Pdo',
    //	'dsn'            => 'mysql:dbname=zf2tutorial;host=localhost',
    //	'driver_options' => array(
    //	    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    //	),
    //    ),

            'factories'=>array(
//		 'Zend\Db\Adapter\Adapter'
  //                  => 'Zend\Db\Adapter\AdapterServiceFactory',
  
                
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
                

        'SanAuth\Model\MyAuthStorage' => function ($sm) {
            return new \SanAuth\Model\MyAuthStorage('zf_tutorial');
        },

        'AuthService' => function ($sm) {
            $dbAdapter      = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'logindaten','Email','Passwort');

            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $authService->setStorage($sm->get('SanAuth\Model\MyAuthStorage'));

            return $authService;
        },
            ),
        );
    }

}
