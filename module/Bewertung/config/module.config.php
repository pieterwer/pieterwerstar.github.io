<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bewertung\Controller\Bewertung' => 'Bewertung\Controller\BewertungController',
            'Bewertung\Controller\Bewertung' => 'Bewertung\Controller\BewertungController'
        )
    ),
    'router' => array(
        'routes' => array(
            'bewertung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/bewertung[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bewertung\Controller',
                        'controller' => 'Bewertung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|durchschnitt)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'bewertung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/bewertung[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bewertung\Controller',
                        'controller' => 'Bewertung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|durchschnitt)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Bewertung' => __DIR__ . '/../view'
        )
    )
);
