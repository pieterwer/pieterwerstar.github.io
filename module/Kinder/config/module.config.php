<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Kinder\Controller\Kinder' => 'Kinder\Controller\KinderController',
            'Kinder\Controller\Kinder' => 'Kinder\Controller\KinderController'
        )
    ),
    'router' => array(
        'routes' => array(
            'kinder' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/kinder[/:action[/:id[/:ev]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kinder\Controller',
                        'controller' => 'Kinder',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|ergebnis|exportAlbum|anmelden|auswahl)',
                        'id' => '[0-9]+'
                    )
                )
            ),
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'kinder' => __DIR__ . '/../view'
        )
    )
);
