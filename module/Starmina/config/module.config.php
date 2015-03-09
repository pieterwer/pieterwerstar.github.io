<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Starmina\Controller\Athlet' => 'Starmina\Controller\AthletController',
						'Starmina\Controller\Verein' => 'Starmina\Controller\VereinController',
						'Starmina\Controller\Veranstaltung' => 'Starmina\Controller\VeranstaltungController',
						'Starmina\Controller\Gutscheincode' => 'Starmina\Controller\GutscheincodeController',
						'Starmina\Controller\Event' => 'Starmina\Controller\EventController',
						'Starmina\Controller\Ergebnis' => 'Starmina\Controller\ErgebnisController',
						'Starmina\Controller\Athletenbezahlung' => 'Starmina\Controller\AthletenbezahlungController',
						'Starmina\Controller\Auth' => 'Starmina\Controller\AuthController',
						'Starmina\Controller\Success' => 'Starmina\Controller\SuccessController',
						'Starmina\Controller\Veranstalter' => 'Starmina\Controller\VeranstalterController' 
				)
				 
		),
		
		'router' => array (
				'routes' => array (
						'athlet' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/athlet[/][:action][/:id]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+' 
										),
										'defaults' => array (
												'controller' => 'Starmina\Controller\Athlet',
												'action' => 'home' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'registrieren' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'registrieren[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'registrieren' 
														) 
												)
												// 'id' => 1 // PR weiß nicht, ob ich die brauch (13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'registrieren' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'profil[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'profil' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								) 
						),
						'veranstaltung' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/veranstaltung[/][:action][/:id]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+' 
										),
										'defaults' => array (
												'controller' => 'Starmina\Controller\Veranstaltung',
												'action' => 'index' 
										) 
								) 
						)
						,
						
						'event' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/event[/][:action][/:id]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+' 
										),
										'defaults' => array (
												'controller' => 'Starmina\Controller\Event',
												'action' => 'index' 
										) 
								) 
						)
						,
						
						'ergebnis' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/ergebnis[/:action[/:id[/:srt]]]',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Ergebnis',
												'action' => 'index' 
										),
										'constraints' => array (
												'action' => '(add|edit|delete|show|showdetail|ergebnis|athletenergebnis|anmelden)', // anmelden und athletenergebnis eingefügt von TW Gruppe7
												'id' => '[0-9]+' 
										) 
								) 
						),
						
						'athletenbezahlung' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/athletenbezahlung[/:action[/:id][/:athletid][/:wert][/:useid]]',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Athletenbezahlung',
												'action' => 'index' 
										),
										'constraints' => array (
												'action' => '(add|edit|delete|show|back|forwardgroup|search|group|forward|kontenbewegung)', // kontenbewegung eingefügt von TW Gruppe7
												'id' => '[0-9]+' 
										) 
								) 
						),
						'athletenbezahlung' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/athletenbezahlung[/:action[/:id][/:athletid][/:wert][/:useid]]',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Athletenbezahlung',
												'action' => 'index' 
										),
										'constraints' => array (
												'action' => '(add|edit|delete|show|back|forwardgroup|search|group|forward|kontenbewegung)', // kontenbewegung eingefügt von TW Gruppe7
												'id' => '[0-9]+' 
										) 
								) 
						),
						'gutscheincode' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/gutscheincode[/][:action][/:id]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+' 
										),
										'defaults' => array (
												'controller' => 'Starmina\Controller\gutscheincode',
												'action' => '' 
										) 
								) 
						)
						,
						'veranstalter' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/veranstalter[/:action[/:id]]',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Veranstalter',
												'action' => 'index' 
										),
										'constraints' => array (
												'action' => '(add|edit|delete|show|showdetail|profil)',
												'id' => '[0-9]+' 
										) 
								) 
						),
						
						'login' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/auth',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Auth',
												'action' => 'login' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'process' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:action]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
														),
														'defaults' => array () 
												) 
										) 
								) 
						),
						
						'success' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/success',
										'defaults' => array (
												'__NAMESPACE__' => 'Starmina\Controller',
												'controller' => 'Success',
												'action' => 'index' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'default' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:action]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
														),
														'defaults' => array () 
												) 
										) 
								) 
						),
						'verein' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/verein[/][:action][/:id]', // /
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+' 
										),
										'defaults' => array (
												'controller' => 'Starmina\Controller\Verein',
												'action' => '' 
										) 
								) // index

								,
								'may_terminate' => true,
								'child_routes' => array (
										'registrieren' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'registrieren[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'registrieren' 
														) 
												)
												// 'id' => 1 // PR weiß nicht, ob ich die brauch (13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'registrieren' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'profil[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'profil' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'edit' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'edit[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'edit' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'edit' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'bestatigung[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'bestatigung' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'wechsel' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'wechsel[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'wechsel' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'anmelden' => array (
												'type' => 'literal',
												'options' => array (
														'route' => 'anmelden[/:id]',
														'constraints' => array (
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id' => '[0-9]+' 
														),
														'default' => array (
																'action' => 'anmelden' 
														) 
												)
												// 'id' => 1 // weiß nicht, ob ich die brauch (PR, 13.12.14)
												
												 
										) 
								) 
						) 
				) 
		),
		
		'view_manager' => array (
				'template_path_stack' => array (
						'athlet' => __DIR__ . '/../view',
						'verein' => __DIR__ . '/../view',
						'veranstaltung' => __DIR__ . '/../view',
						'ergebnis' => __DIR__ . '/../view',
						'Athletenbezahlung' => __DIR__ . '/../view',
						'SanAuth' => __DIR__ . '/../view',
						'Veranstalter' => __DIR__ . '/../view' 
				)
				 
		) 
);