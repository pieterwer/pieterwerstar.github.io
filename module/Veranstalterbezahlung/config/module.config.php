<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Veranstalterbezahlung\Controller\Veranstalterbezahlung' => 'Veranstalterbezahlung\Controller\VeranstalterbezahlungController',
            'Veranstalterbezahlung\Controller\Veranstalterbezahlung' => 'Veranstalterbezahlung\Controller\VeranstalterbezahlungController'
        )
    ),
    'router' => array(
        'routes' => array(
            'veranstalterbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/veranstalterbezahlung[/:action[/:id][/:veranstalterid][/:useid][/:wert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'veranstalterbezahlung\Controller',
                        'controller' => 'Veranstalterbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|search|forward|back|group)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'veranstalterbezahlung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/veranstalterbezahlung[/:action[/:id][/:veranstalterid][/:useid][/:wert]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Veranstalterbezahlung\Controller',
                        'controller' => 'Veranstalterbezahlung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|search|forward|back|group)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Veranstalterbezahlung' => __DIR__ . '/../view'
        )
    )
);
