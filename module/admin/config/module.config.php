<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Segment',
                   'options' => array(
                      'route' => '/admin[/:action[/:id]]',
                         'defaults' => array(
                            '__NAMESPACE__' => 'Admin\Controller',
                              'controller' => 'Admin',
                                 'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show)',
                        'id' => '[0-9]+'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
    ),
);
