<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Athletenbezahlung\Controller\Athletenbezahlung' => 'Athletenbezahlung\Controller\AthletenbezahlungController',
            'Athletenbezahlung\Controller\Athletenbezahlung' => 'Athletenbezahlung\Controller\AthletenbezahlungController'
        )
    ),
    'router' => array(
        'routes' => array(
            'athletenbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athletenbezahlung[/:action[/:id][/:athletid][/:wert][/:useid][/:sumwert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athletenbezahlung\Controller',
                        'controller' => 'Athletenbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|back|forwardgroup|search|group|forward|kontenbewegung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'athletenbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athletenbezahlung[/:action[/:id][/:athletid][/:wert][/:useid][/:sumwert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athletenbezahlung\Controller',
                        'controller' => 'Athletenbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|back|forwardgroup|search|group|forward|kontenbewegung)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Athletenbezahlung' => __DIR__ . '/../view'
        )
    )
);
