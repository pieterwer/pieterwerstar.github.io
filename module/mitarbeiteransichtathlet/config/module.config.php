<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mitarbeiteransichtathlet\Controller\Mitarbeiteransichtathlet' => 'Mitarbeiteransichtathlet\Controller\MitarbeiteransichtathletController',
            'Mitarbeiteransichtathlet\Controller\Mitarbeiteransichtathlet' => 'Mitarbeiteransichtathlet\Controller\MitarbeiteransichtathletController'
        )
    ),
    'router' => array(
        'routes' => array(
            'mitarbeiteransichtathlet' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeiteransichtathlet[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'mitarbeiteransichtathlet\Controller',
                        'controller' => 'Mitarbeiteransichtathlet',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                       'action' => '(add|edit|delete|show|showdetail|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'mitarbeiteransichtathlet' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeiteransichtathlet[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Mitarbeiteransichtathlet\Controller',
                        'controller' => 'Mitarbeiteransichtathlet',
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
            'Mitarbeiteransichtathlet' => __DIR__ . '/../view'
        )
    )
);
