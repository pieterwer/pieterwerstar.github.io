<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Strecke\Controller\Strecke' => 'Strecke\Controller\StreckeController',
            'Strecke\Controller\Strecke' => 'Strecke\Controller\StreckeController'
        )
    ),
    'router' => array(
        'routes' => array(
            'strecke' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/strecke[/:action[/:id[/:srt]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Strecke\Controller',
                        'controller' => 'Strecke',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|ergebnis|exportAlbum|anmelden)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'strecke' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/strecke[/:action[/:id[/:srt]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Strecke\Controller',
                        'controller' => 'Strecke',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|ergebnis|exportAlbum|anmelden)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'strecke' => __DIR__ . '/../view'
        )
    )
);
