<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Hilfe\Controller\Hilfe' => 'Hilfe\Controller\HilfeController',
            'Hilfe\Controller\Hilfe' => 'Hilfe\Controller\HilfeController'
        )
    ),
    'router' => array(
        'routes' => array(
            'Hilfe' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/Hilfe[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Hilfe\Controller',
                        'controller' => 'Hilfe',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(index|faq)'
                    )
                )
            ),
            'Hilfe' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/Hilfe[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Hilfe\Controller',
                        'controller' => 'Hilfe',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(index|faq)'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Hilfe' => __DIR__ . '/../view'
        )
    )
);
