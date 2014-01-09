<?php

namespace Actividad;

return array(
    // Se define como se manejan las rutas del controlador
    'router' => array(
        'routes' => array(
            'actividad' => array( // modulo en minuscula
                'type' => 'Literal',
                'options' => array(
                    'route' => '/actividad',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Actividad\Controller',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
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
    
    'controllers' => array(
        'invokables' => array(  // Se invoca el controlador
            'Actividad\Controller\Actividad'     => 'Actividad\Controller\ActividadController',
            'Actividad\Controller\ActividadTipo' => 'Actividad\Controller\ActividadTipoController',
            'Actividad\Controller\Ciclo'         => 'Actividad\Controller\CicloController',
            'Actividad\Controller\Combos'        => 'Actividad\Controller\CombosController',
        ),
    ),
    
    // Cargamos el view manager
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'actividad/index/index'   => __DIR__ . '/../view/actividad/index/index.phtml', //Donde va a estar la vista por defecto
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
    
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
);
