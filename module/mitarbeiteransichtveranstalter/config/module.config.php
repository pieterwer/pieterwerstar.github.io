<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mitarbeiteransichtveranstalter\Controller\Mitarbeiteransichtveranstalter' => 'Mitarbeiteransichtveranstalter\Controller\MitarbeiteransichtveranstalterController',
            'Mitarbeiteransichtveranstalter\Controller\Mitarbeiteransichtveranstalter' => 'Mitarbeiteransichtveranstalter\Controller\MitarbeiteransichtveranstalterController'
        )
    ),
    'router' => array(
        'routes' => array(
            'mitarbeiteransichtveranstalter' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeiteransichtveranstalter[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'mitarbeiteransichtveranstalter\Controller',
                        'controller' => 'Mitarbeiteransichtveranstalter',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'mitarbeiteransichtveranstalter' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mitarbeiteransichtveranstalter[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Mitarbeiteransichtveranstalter\Controller',
                        'controller' => 'Mitarbeiteransichtveranstalter',
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
            'Mitarbeiteransichtveranstalter' => __DIR__ . '/../view'
        )
    )
);
