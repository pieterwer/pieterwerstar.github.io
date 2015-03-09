<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Shop\Controller\Shop' => 'Shop\Controller\ShopController',
            'Shop\Controller\Shop' => 'Shop\Controller\ShopController'
        )
    ),
    'router' => array(
        'routes' => array(
            'shop' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/shop[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shop',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|showdetail|ergebnis|exportAlbum|Artikelbild|warenkorb|ansichtwarenkorb|bestellungen|bestellen|shopve|orderbetreiber)',
                        'id' => '[0-9]+'
                    )
                )
            ),
            'shop' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/shop[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shop',
                        'action' => 'index'
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|show|ergebnis|exportAlbum|anmelden|Artikelbild|warenkorb|ansichtwarenkorb|bestellungen|bestellen|shopve|orderbetreiber)',
                        'id' => '[0-9]+'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'shop' => __DIR__ . '/../view'
        )
    )
);
