<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Pwvergessen\Controller\Pwvergessen' => 'Pwvergessen\Controller\PwvergessenController',
            'Pwvergessen\Controller\Pwvergessen' => 'Pwvergessen\Controller\PwvergessenController'
        )
    ),
    'router' => array(
        'routes' => array(
            'pwvergessen' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/pwvergessen[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Pwvergessen\Controller',
                        'controller' => 'Pwvergessen',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(index)'
                    )
                )
            ),
            'pwvergessen' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/pwvergessen[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Pwvergessen\Controller',
                        'controller' => 'Pwvergessen',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(index)'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Pwvergessen' => __DIR__ . '/../view'
        )
    )
);
