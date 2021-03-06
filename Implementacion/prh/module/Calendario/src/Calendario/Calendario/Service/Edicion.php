<?php

namespace Calendario\Calendario\Service;

use EnterpriseSolutions\Simple\Cambios\Cambios;
use Calendario\Calendario\Repository;
use EnterpriseSolutions\Exceptions\Thrower;
//use Adm\Usuario\Service\Creacion\Validacion;

class Edicion
{
	public $_repository;

	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{

		$calAnhoFormacion 	= $this->_repository->getCalAnhoFormacion($params['cal_anho_formacion_id']);
		$cambiosCalendario 	= $this->_editarCalendario($calAnhoFormacion, $params, $this->_repository);

		if($params['actual'] === 'S')
		{
			$calendarios 	= $this->_repository->getCalendariosNoActuales($params['cal_anho_formacion_id']);
			foreach ($calendarios as $key => $value) {
			 	$cambiosActual 	= $this->_editarCalendario($calendarios[$key], array("actual" => "N"), $this->_repository);	
			}
		}
			

		return $this->_construirRespuesta($calAnhoFormacion, $cambiosCalendario);
	}
	
	public function _editarCalendario($calAnhoFormacion,$params,$repository)
	{
	    $cambios 			= new Cambios();
		$cambiosEnviados	= $cambios->mapearComoCambios($params,array('anho', 'fecha_inicio', 'fecha_fin', 'descripcion', 'actual'));
		$cambiosCalendario  = $cambios->cambiar($calAnhoFormacion, $cambiosEnviados);

		return $repository->persistirCambiosADatos($cambiosCalendario, $calAnhoFormacion, 'cal_anho_formacion', 'cal_anho_formacion_id');
	}
	
	public function _construirRespuesta($calAnhoFormacion,$cambiosCalendario)
	{
		$cambios = new Cambios;
		
		return array(
			'status'  => true,
			'mensaje' => 'Año de Formación editado exitosamente',
			'datos'   => array(
				'campos_modificados' => $cambios->getCamposCambiados($cambiosCalendario)		
			) 	
		);
	}
}