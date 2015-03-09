<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Betreiber\Controller\Betreiber' => 'Betreiber\Controller\BetreiberController',
            'Betreiber\Controller\Betreiber' => 'Betreiber\Controller\BetreiberController'
        )
    ),
    'router' => array(
        'routes' => array(
            'betreiber' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/betreiber[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Betreiber\Controller',
                        'controller' => 'Betreiber',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|search|bearbeiten)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'betreiber' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/betreiber[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Betreiber\Controller',
                        'controller' => 'Betreiber',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|search|bearbeiten)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Betreiber' => __DIR__ . '/../view'
        )
    )
);
