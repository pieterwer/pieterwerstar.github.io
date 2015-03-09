<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Vereinsuche\Controller\Vereinsuche' => 'Vereinsuche\Controller\VereinsucheController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'vereinsuche' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/vereinsuche[/][:action][/:id][/:name]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                         'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Vereinsuche\Controller\Vereinsuche',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'vereinsuche' => __DIR__ . '/../view',
         ),
     ),
 );
