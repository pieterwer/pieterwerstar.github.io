<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Vereinsadminaendern\Controller\Vereinsadminaendern' => 'Vereinsadminaendern\Controller\VereinsadminaendernController',
            'Vereinsadminaendern\Controller\Vereinsadminaendern' => 'Vereinsadminaendern\Controller\VereinsadminaendernController'
        )
    ),
    'router' => array(
        'routes' => array(
            'vereinsadminaendern' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereinsadminaendern[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereinsadminaendern\Controller',
                        'controller' => 'Vereinsadminaendern',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|update|search)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'vereinsadminaendern' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/vereinsadminaendern[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vereinsadminaendern\Controller',
                        'controller' => 'Vereinsadminaendern',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|update|search)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Vereinsadminaendern' => __DIR__ . '/../view'
        )
    )
);
