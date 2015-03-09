<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Vereinbezahlung\Controller\Vereinbezahlung' => 'Vereinbezahlung\Controller\VereinbezahlungController',
            'Vereinbezahlung\Controller\Vereinbezahlung' => 'Vereinbezahlung\Controller\VereinbezahlungController'
        )
    ),
    'router' => array(
        'routes' => array(
            'vereinbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereinbezahlung[/:action[/:id][/:vereinid][/:useid][/:wert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereinbezahlung\Controller',
                        'controller' => 'Vereinbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|forwardgroup|forward|back|search|group)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'vereinbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereinbezahlung[/:action[/:id][/:vereinid][/:useid][/:wert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereinbezahlung\Controller',
                        'controller' => 'Vereinbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|forwardgroup|forward|back|search|group)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Vereinbezahlung' => __DIR__ . '/../view'
        )
    )
);
