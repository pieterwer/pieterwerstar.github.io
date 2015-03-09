<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Werbeauftrag\Controller\Werbeauftrag' => 'Werbeauftrag\Controller\WerbeauftragController',
            'Werbeauftrag\Controller\Werbeauftrag' => 'Werbeauftrag\Controller\WerbeauftragController'
        )
    ),
    'router' => array(
        'routes' => array(
            'werbeauftrag' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/werbeauftrag[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Werbeauftrag\Controller',
                        'controller' => 'Werbeauftrag',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'werbeauftrag' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/werbeauftrag[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Werbeauftrag\Controller',
                        'controller' => 'Werbeauftrag',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|search|zuordnung|werbeauftragveranstalterzuordnung|werbeauftragathletenzuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Werbeauftrag' => __DIR__ . '/../view'
        )
    )
);
