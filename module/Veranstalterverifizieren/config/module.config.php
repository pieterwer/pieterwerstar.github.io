<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'Veranstalterverifizieren\Controller\Veranstalterverifizieren' => 'Veranstalterverifizieren\Controller\VeranstalterverifizierenController',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'veranstalterverifizieren' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/veranstalterverifizieren[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Veranstalterverifizieren\Controller',
                        'controller'     => 'Veranstalterverifizieren',
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
            'Veranstalterverifizieren' => __DIR__ . '/../view',
        )
    )
);