<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bild\Controller\Veranstalter' => 'Bild\Controller\BildController',
            'Bild\Controller\Bild' => 'Bild\Controller\BildController'
        )
    ),
    'router' => array(
        'routes' => array(
            'bild' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/bild[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bild\Controller',
                        'controller' => 'Bild',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|artikelbild|veranstaltung|event)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'bild' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/bild[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bild\Controller',
                        'controller' => 'Bild',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|artikelbild|veranstaltung|event)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Bild' => __DIR__ . '/../view'
        )
    )
);
