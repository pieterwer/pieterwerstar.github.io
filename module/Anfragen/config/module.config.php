<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Anfragen\Controller\Anfragen' => 'Anfragen\Controller\AnfragenController',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'anfragen' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/anfragen[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Anfragen\Controller',
                        'controller'     => 'Anfragen',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(index)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Anfragen' => __DIR__ . '/../view',
        )
    )
);