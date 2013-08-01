<?php
//Versión más resumida

return array(
		'controllers'=>array(
				'invokables'=>array(//Se invoca el controlador
						'Actividad\Controller\Index'=>'Actividad\Controller\IndexController'
				),
		),
		 
		//Se define como se manejan las rutas del controlador
		'router'=>array(
				'routes'=>array(
						'actividad'=>array( //modulo en minuscula
								'type'=>'Segment',
								'options'=>array(

										'route' => '/actividad[/[:action]]', //modulo
										'constraints' => array(
												'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
										),

										'defaults'  =>  array(//Se define un controlador por defecto
												'controller' => 'Actividad\Controller\Index',
												'action'     => 'index'
             
										),
								),
						),
				),
		),

		//Cargamos el view manager
		'view_manager' => array(
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => array(
						'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
						'actividad/index/index'   => __DIR__ . '/../view/actividad/index/index.phtml', //Donde va a estar la vista por defecto
						'error/404'               => __DIR__ . '/../view/error/404.phtml',
						'error/index'             => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array(
						'actividad' =>  __DIR__ . '/../view',
				),
		),
);