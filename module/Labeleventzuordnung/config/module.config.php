<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Labeleventzuordnung\Controller\Labeleventzuordnung' => 'Labeleventzuordnung\Controller\LabeleventzuordnungController',
            'Labeleventzuordnung\Controller\Labeleventzuordnung' => 'Labeleventzuordnung\Controller\LabeleventzuordnungController'
        )
    ),
    'router' => array(
        'routes' => array(
            'labeleventzuordnung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/labeleventzuordnung[/:action[/:eventid[/:labelid]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Labeleventzuordnung\Controller',
                        'controller' => 'Labeleventzuordnung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(editstatus|delete)',
                        'eventid' => '[0-9]+'
                    )
                )
            ),
            'labeleventzuordnung' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/labeleventzuordnung[/:action[/:eventid[/:labelid]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Labeleventzuordnung\Controller',
                        'controller' => 'Labeleventzuordnung',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(editstatus|delete)',
                        'eventid' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Labeleventzuordnung' => __DIR__ . '/../view'
        )
    )
);
