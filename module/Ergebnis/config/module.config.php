<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Ergebnis\Controller\Ergebnis' => 'Ergebnis\Controller\ErgebnisController',
            'Ergebnis\Controller\Ergebnis' => 'Ergebnis\Controller\ErgebnisController'
        )
    ),
    'router' => array(
        'routes' => array(
            'ergebnis' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ergebnis[/:action[/:id[/:kid]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Ergebnis\Controller',
                        'controller' => 'Ergebnis',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(import|add|edit|delete|show|showdetail|ergebnis|export|anmelden|kind|abmelden|teilnehmer|athletenergebnis|anmelden)',
                        'id' => '[0-9]+'
                    )
                )
            ),
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ergebnis' => __DIR__ . '/../view'
        )
    )
);
