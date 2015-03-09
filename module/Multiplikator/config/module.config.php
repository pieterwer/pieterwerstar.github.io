<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Multiplikator\Controller\Multiplikator' => 'Multiplikator\Controller\MultiplikatorController',
            'Multiplikator\Controller\Multiplikator' => 'Multiplikator\Controller\MultiplikatorController'
        )
    ),
    'router' => array(
        'routes' => array(
            'multiplikator' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/multiplikator[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Multiplikator\Controller',
                        'controller' => 'Multiplikator',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'multiplikator' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/multiplikator[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Multiplikator\Controller',
                        'controller' => 'Multiplikator',
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
            'Multiplikator' => __DIR__ . '/../view'
        )
    )
);
