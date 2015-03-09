<?php
 return array(
     'controllers' => array(
         'invokables' => array(
             'Gutscheincode\Controller\Gutscheincode' => 'Gutscheincode\Controller\GutscheincodeController',
         ),
     ),

   // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'gutscheincode' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/gutscheincode[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-99999999999999]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Gutscheincode\Controller\Gutscheincode',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
     

     

     'view_manager' => array(
         'template_path_stack' => array(
             'gutscheincode' => __DIR__ . '/../view',
         ),
     ),
   //NEU  
 
);