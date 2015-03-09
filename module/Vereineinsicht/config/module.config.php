<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Vereineinsicht\Controller\Vereineinsicht' => 'Vereineinsicht\Controller\VereineinsichtController',
            'Vereineinsicht\Controller\Vereineinsicht' => 'Vereineinsicht\Controller\VereineinsichtController'
        )
    ),
    'router' => array(
        'routes' => array(
            'vereineinsicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereineinsicht[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereineinsicht\Controller',
                        'controller' => 'Vereineinsicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|profil)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'vereineinsicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereineinsicht[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereineinsicht\Controller',
                        'controller' => 'Vereineinsicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|profil)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Vereineinsicht' => __DIR__ . '/../view'
        )
    )
);
