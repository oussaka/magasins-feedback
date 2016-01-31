<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'UsersRest\Controller\UsersRest' => 'UsersRest\Controller\UsersRestController',
        ),
    ),
    // Setup Rest Routing : need to first add our custom REST routing so we are able to call the RestController.
    'router' => array(
        'routes' => array(
            'users-rest' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/users-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'UsersRest\Controller\UsersRest',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        /* 'template_path_stack' => array(
            'Users-rest' => __DIR__ . '/../view',
        ), */
    ),
);