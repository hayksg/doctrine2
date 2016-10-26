<?php

namespace Blog;

return array(
    'doctrine' => array(
        'driver' => array(
            'Blog_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Blog/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Blog\Entity' =>  'Blog_driver'
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route' => '/blog[/page/:page][/:action[/:id]]',
                    'constraints' => [
                        'action' => '[A-Za-z][a-z0-9-_]*',
                        'id'     => '[0-9]+',
                        'page'   => '[0-9]+',
                    ],
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            //'Blog\Controller\Index' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            //'layout/layout'    => __DIR__ . '/../view/layout/layout.phtml',
            'blog/index/index' => __DIR__ . '/../view/blog/index/index.phtml',
            'error/404'        => __DIR__ . '/../view/error/404.phtml',
            'error/index'      => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
