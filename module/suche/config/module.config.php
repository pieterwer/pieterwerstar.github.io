<?php
 return array(
     'controllers' => array(
         'invokables' => array(
             'Suche\Controller\Suche' => 'Suche\Controller\SucheController',
         ),
     ),

   // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'suche' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/suche[/][:action][/:vorname][/:name]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'name'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'vorname'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Suche\Controller\Suche',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
     
//NEU 4.1.2015


     
//ENDE     
     

     'view_manager' => array(
         'template_path_stack' => array(
             'suche' => __DIR__ . '/../view',
         ),
     ),
 
 
);
 //NEU
 return array(
     'controllers' => array(
         'invokables' => array(
             'Athletenhistorie\Controller\Athletenhistorie' => 'Athletenhistorie\Controller\AthletenhistorieController',
         ),
     ),
 
     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'suche' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/athletenhistorie[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Athletenhistorie\Controller\Athletenhistorie',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
      
     //NEU 4.1.2015
 
 
      
                     //ENDE
      
 
     'view_manager' => array(
         'template_path_stack' => array(
             'suche' => __DIR__ . '/../view',
         ),
     ),
 
 
 );
 
 