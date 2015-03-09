<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Search\Controller\Search' => 'Search\Controller\SearchController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Search\Controller',
                        'controller' => 'Search',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Search' => __DIR__ . '/../view',
        ),
    ),
);
