<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Cashbackmultiplikator\Controller\Cashbackmultiplikator' => 'Cashbackmultiplikator\Controller\CashbackmultiplikatorController',
            'Cashbackmultiplikator\Controller\Cashbackmultiplikator' => 'Cashbackmultiplikator\Controller\CashbackmultiplikatorController'
        )
    ),
    'router' => array(
        'routes' => array(
            'cashbackmultiplikator' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/cashbackmultiplikator[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Cashbackmultiplikator\Controller',
                        'controller' => 'Cashbackmultiplikator',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(edit|delete)',
                        'id' => '[0-9]+'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Cashbackmultiplikator' => __DIR__ . '/../view'
        )
    )
);
