<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Login' => 'Login\Controller\LoginController',
            'Login\Controller\Login' => 'Login\Controller\LoginController'
        )
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'Login',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Login\Controller',
                        'controller' => 'Login',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Login' => __DIR__ . '/../view'
        )
    )
);
