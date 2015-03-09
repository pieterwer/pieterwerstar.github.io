<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Athleteinsicht\Controller\Athleteinsicht' => 'Athleteinsicht\Controller\AthleteinsichtController',
            'Athleteinsicht\Controller\Athleteinsicht' => 'Athleteinsicht\Controller\AthleteinsichtController'
        )
    ),
    'router' => array(
        'routes' => array(
            'athleteinsicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athleteinsicht[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athleteinsicht\Controller',
                        'controller' => 'Athleteinsicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|profil|zuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'athleteinsicht' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/athleteinsicht[/:action[/:id][/:email]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Athleteinsicht\Controller',
                        'controller' => 'Athleteinsicht',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|profil|zuordnung)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Athleteinsicht' => __DIR__ . '/../view'
        )
    )
);
