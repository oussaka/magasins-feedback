<?php
return array(
		'router' => array(
				'routes' => array(
						'etablissement' => array(
								'type'    => 'Segment',
								'options' => array(
										'route'    => '/etablissement',
										'defaults' => array(
												'__NAMESPACE__' => 'Etablissement\Controller',
												'controller'    => 'Etablissement',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]][/:id]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
																'controller' => 'Etablissement',
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
						'Etablissement\Controller\Etablissement' => 'Etablissement\Controller\EtablissementController',
						'Etablissement\Controller\Pui' => 'Etablissement\Controller\PuiController',
				),
		),
		

		'view_manager' => array(
				'template_map' => array(
						'etablissement/etablissement/index' => __DIR__ . '/../view/etablissement/etablissement/index.phtml',
				),
				'template_path_stack' => array(
						__DIR__ . '/../view',
				),
		),
);