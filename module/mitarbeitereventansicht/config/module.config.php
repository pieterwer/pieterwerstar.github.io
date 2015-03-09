<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mitarbeitereventansicht\Controller\Mitarbeitereventansicht' => 'Mitarbeitereventansicht\Controller\MitarbeitereventansichtController',
            'Mitarbeitereventansicht\Controller\Mitarbeitereventansicht' => 'Mitarbeitereventansicht\Controller\MitarbeitereventansichtController'
        )
    ),
    'router' => array(
        'routes' => array(
            'mitarbeitereventansicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeitereventansicht[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'mitarbeitereventansicht\Controller',
                        'controller' => 'Mitarbeitereventansicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                      'action' => '(add|edit|delete|show|showdetail|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'mitarbeitereventansicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeitereventansicht[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Mitarbeitereventansicht\Controller',
                        'controller' => 'Mitarbeitereventansicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Mitarbeitereventansicht' => __DIR__ . '/../view'
        )
    )
);
