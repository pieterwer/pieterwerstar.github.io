<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bonusbetrag\Controller\Bonusbetrag' => 'Bonusbetrag\Controller\BonusbetragController',
            'Bonusbetrag\Controller\Bonusbetrag' => 'Bonusbetrag\Controller\BonusbetragController'
        )
    ),
    'router' => array(
        'routes' => array(
            'bonusbetrag' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/bonusbetrag[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bonusbetrag\Controller',
                        'controller' => 'Bonusbetrag',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(edit|index)',
                        'id' => '[0-9]+'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Bonusbetrag' => __DIR__ . '/../view'
        )
    )
);
