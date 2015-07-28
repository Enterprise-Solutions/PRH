<?php

namespace Calendario\Calendario\Service;

use Calendario\Calendario\Repository;
use Calendario\Calendario\Service\Edicion;

use EnterpriseSolutions\Simple\Cambios\Cambios;
use EnterpriseSolutions\Exceptions\Thrower;

class Creacion
{
	public $_repository;

	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{		
		$this->_validarOperacion($params);
		$params['cal_anho_formacion_id'] = $this->_crearAnhoFormacion($params, $this->_repository);

		if($params['actual'] === 'S')
		{
			$edicion 		= new Edicion($this->_repository);
			$calendarios 	= $this->_repository->getCalendariosNoActuales($params['cal_anho_formacion_id']);
			foreach ($calendarios as $key => $value) {
			 	$cambiosActual 	= $edicion->_editarCalendario($calendarios[$key], array("actual" => "N"), $this->_repository);	
			}
		}

		return $this->_construirRespuesta($params);
	}
		
	public function _validarOperacion($datos)
	{
        //Validar que el anho de formacion no exista
        $existeAnho     = $this->_repository->findAnhos($datos['anho']);

        if($existeAnho)
            Thrower::throwValidationException('Error de validacion','Ya existe el año de formación ingresado');

        //Validar las fechas
        if ($datos['fecha_inicio'] > $datos['fecha_fin'])
            Thrower::throwValidationException('Error de validacion','La fecha de inicio no puede ser mayor a la fecha fin');            
	}
	
	public function _crearAnhoFormacion($params,$repository)
	{
		$cambios              = new Cambios();
        $cambiosEnviados      = $cambios->mapearComoCambios($params,array('org_parte_rol_centro', 'anho', 'fecha_inicio', 'fecha_fin', 'descripcion', 'actual'));
		$cambiosAnhoFormacion = $cambios->cambiar(array(), $cambiosEnviados);
        
		$cambiosAnhoId        = $repository->persistirCambiosADatos($cambiosAnhoFormacion, array(),'cal_anho_formacion', 'cal_anho_formacion_id');
		return $cambios->getValorNuevo($cambiosAnhoId, 'cal_anho_formacion_id');
	}
	
	public function _construirRespuesta($params)
	{
		return array(
			'status' => true,
			'mensaje' => 'Año de Formación creado Exitosamente',
			'datos'   => array(
				'cal_anho_formacion_id' => $params['cal_anho_formacion_id']
			)	
		);
	}
}