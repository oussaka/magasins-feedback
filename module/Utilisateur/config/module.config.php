<?php
return array(
		'router' => array(
				'routes' => array(
						'utilisateur' => array(
								'type'    => 'Segment',
								'options' => array(
										'route'    => '/utilisateur',
										'defaults' => array(
												'__NAMESPACE__' => 'Utilisateur\Controller',
												'controller'    => 'Utilisateur',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]][/:id][/id/:id][/secret[/:secret]]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
																'controller' => 'Utilisateur',
																'action' => 'index',
														),
												),
										),
								),
						),
				),
		),
			
		'controllers' => array(
				'invokables' => array(
						'Utilisateur\Controller\Utilisateur' => 'Utilisateur\Controller\UtilisateurController'
				),
		),
		
		
		'view_manager' => array(
				'template_map' => array(
						'utilisateur/utilisateur/index' => __DIR__ . '/../view/utilisateur/utilisateur/index.phtml',
				),
				'template_path_stack' => array(
						__DIR__ . '/../view',
				),
		),
);