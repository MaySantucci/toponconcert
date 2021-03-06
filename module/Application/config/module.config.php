<?php

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user[/:action]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'concert' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/concert[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ConcertController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'ticket' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/ticket[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\TicketController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\UserController::class => \Application\Controller\Factory\UserControllerFactory::class,
            Controller\ConcertController::class => \Application\Controller\Factory\ConcertControllerFactory::class,
            Controller\TicketController::class => \Application\Controller\Factory\TicketControllerFactory::class
        ],
    ],
    'service_manager' => [
        'invokables' => [
            Form\User\RegisterForm::class => Form\User\RegisterForm::class,
            Form\Concert\ConcertForm::class => Form\Concert\ConcertForm::class,
        ],
        'factories' => [
            Service\UserManager::class => Service\Factory\UserManagerFactory::class,
            Service\ConcertManager::class => Service\Factory\ConcertManagerFactory::class,
            Service\OrganizerManager::class => Service\Factory\OrganizerManagerFactory::class,
            Service\TicketManager::class => Service\Factory\TicketManagerFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            Service\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            \Application\View\Helper\Authentication::class => \Application\View\Helper\Factory\AuthenticationFactory::class,
        ],
        'aliases' => [
            'identity' => \Application\View\Helper\Authentication::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
