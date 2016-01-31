<?php
return array(
	/* 'errors' => array(
		'post_processor' => 'json-pp',
		'show_exceptions' => array(
			'message' => true,
			'trace'   => true
		)
	),
	'di' => array(
		'instance' => array(
			'alias' => array(
				'json-pp'  => 'Main\PostProcessor\Json',
				'image-pp' => 'Main\PostProcessor\Image',
				'xml-pp'   => 'Main\PostProcessor\Xml',
				'phps-pp'  => 'Main\PostProcessor\Phps',
			)
		)
	), */
	'controllers' => array(
		'invokables' => array(
            'IndicsUsersRest\Controller\IndicsUsersRest' => 'IndicsUsersRest\Controller\IndicsUsersController',
		)
	),
	'router' => array(
		'routes' => array(
			'indics-users-rest' => array(
				'type'    => 'Zend\Mvc\Router\Http\Segment',
				'options' => array(
					'route'       => '/indics-users-restful[/:id]',
					'constraints' => array(
						'id'         => '[0-9]*'
					),
                    'defaults' => array(
                        'controller' => 'IndicsUsersRest\Controller\IndicsUsersRest',
                    ),
				),
			),
		),
	),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
