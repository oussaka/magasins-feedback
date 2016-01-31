<?php
namespace Indicateur;

return array(
    'controllers' => array(
        'invokables' => array(
            'Indicateur\Controller\Index' => 'Indicateur\Controller\IndexController',
            // 'Indicateur\Controller\ScoreAjax' => 'Indicateur\Controller\ScoreAjaxController',
        ),
        /*
         * abstract_factories : Unknown Services. In this case, if SM could not find controllers in invokables, the SM will turn to it whenever canCreateServiceWithName return true; ( controllers is service that called automatically by mvc stack )
         */
        'abstract_factories' => array(
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
        )
    ),
    'router' => array(
        'routes' => array(
            'indicateur' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/indicateur[/page/:page][/search_by/:search_by][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'search_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\Index',
                        'action'     => 'index',
                        'page'       => 1
                    ),
                ),
            ),
            'mesIndicateurs' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mes-indicateurs[/page/:page][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\Index',
                        'action'     => 'mesIndics',
                        'page'       => 1
                    ),
                ),
            ),
            'attribuer-indic' => array(
                'type'      => 'literal',
                'options' => array(
                    'route'    => '/attribuer-indicateur',
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\Index',
                        'action'     => 'attribUser',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'par-user' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/par-utilisateur/:userId',
                            'constraints' => array(
                                'userId'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'attribUser'
                            )
                        )
                    ),
                    'par-indic' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/par-indicateur/:indicId',
                            'constraints' => array(
                              'indicId'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'attribIndicateur'
                            )
                        )
                    ),
                ),
            ),
            /*'indics-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/indics-user[/:userId]',
                    'constraints' => array(
                        'userId'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\Index',
                        'action'     => 'getIndicByUser',
                    ),
                ),
            ),*/
            'users-by-indic' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/users-indic[/:indicId]',
                    'constraints' => array(
                        'indicId'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\ScoreAjax',
                        'action'     => 'getUsersByIndic',
                    ),
                ),
            ),
            'saisiescore' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/saisie-score[/:indicId]',
                    'constraints' => array(
                        'indicId'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\Index',
                        'action'     => 'saisieScore',
                    ),
                ),
            ),
            // TODO : modifier en RESTful
            'score' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/score-save[/:indicId]',
                    'constraints' => array(
                        'indicId'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\ScoreAjax',
                        'action'     => 'post-score',
                    ),
                ),
            ),
            'getscore' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/score-get[/:indicId]',
                    'constraints' => array(
                        'indicId'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Indicateur\Controller\ScoreAjax',
                        'action'     => 'get-score',
                    ),
                ),
            ),
            /* 'paginator' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/paginator[/:action][/:id][/page/:page][/filter/:filter][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'filter' => '\w+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'paginator',
                    ),
                ),
            ), */
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'Indicateur_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Indicateur/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Indicateur\Entity' =>  'Indicateur_driver'
                ),
            ),
        ),
    ),
    /*
     * 'service_manager' => array(
        'abstract_factories' => array(),
        'aliases' => array(),
        'factories' => array(),
        'invokables' => array(),
        'services' => array(),
        'shared' => array(
            // Usually, you'll only indicate services that should _NOT_ be
            // shared -- i.e., ones where you want a different instance
            // every time.
            'MyTable' => false,
        ),
        /**
         * Override your existing Services.
         * /
        'allow_override' => array(
            'MyService' => true,
        ),
    ),
     */
    'service_manager' => array(
        'invokables' => array(
            // 'my-foo' => 'MyModule\Foo\Bar'
            'MySampleListener' => __NAMESPACE__.'\Event\MySampleListener',
        ),
        /*'abstract_factories' => array(
                'Album\Service\CommonModelTableAbstractFactory',
        ),*/
        /**
         * It initialize the service whenever service created. It can reduce the redundance the injections to services.
         */
        'initializers' => array(
            function ($instance, $sm) {
                if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                    $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                }
            }
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            // 'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
            'paginator' => __DIR__ . '/../view/layout/indicateursPagination.phtml',
            // 'breadcrumb' => __DIR__ . '/../view/layout/adminBreadcrumb.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'pagination' => array(
        'per_page_size' => 5,
    ),
);