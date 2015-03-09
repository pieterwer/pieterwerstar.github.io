<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'Lizenz\Controller\Lizenz' => 'Lizenz\Controller\LizenzController',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'lizenz' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/lizenz[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Lizenz\Controller',
                        'controller'     => 'Lizenz',
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
            'anfragen' => __DIR__ . '/../view',
        )
    )
);