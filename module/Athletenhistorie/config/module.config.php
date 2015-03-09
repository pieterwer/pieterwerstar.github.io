<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Athletenhistorie\Controller\Athletenhistorie' => 'Athletenhistorie\Controller\AthletenhistorieController',
            'Athletenhistorie\Controller\Athletenhistorie' => 'Athletenhistorie\Controller\AthletenhistorieController'
        )
    ),
    'router' => array(
        'routes' => array(
            'athletenhistorie' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athletenhistorie[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athletenhistorie\Controller',
                        'controller' => 'Athletenhistorie',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'athletenhistorie' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athletenhistorie[[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athletenhistorie\Controller',
                        'controller' => 'Athletenhistorie',
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
            'Athletenhistorie' => __DIR__ . '/../view'
        )
    )
);
