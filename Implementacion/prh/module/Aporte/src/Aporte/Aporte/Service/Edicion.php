<?php

namespace Aporte\Aporte\Service;

use EnterpriseSolutions\Simple\Cambios\Cambios;
use Aporte\Aporte\Repository;
use EnterpriseSolutions\Exceptions\Thrower;


class Edicion
{
	public $_repository;

	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{

		$aporte 		= $this->_repository->getAporte($params['Aporte']['ap_aporte_id']);

		if($aporte)
			$cambiosAporte 	= $this->_editarAporte($aporte, $params['Aporte'], $this->_repository);
		else
			Thrower::throwValidationException('Error de Validacion', "No se encuentra el aporte");

		$detalle 		= $this->_repository->getDetalle($params['Detalle']['ap_aporte_detalle_id']);
		if($detalle)
			$cambiosDetalle = $this->_editarDetalle($detalle, $params['Detalle'], $this->_repository);
		else
			Thrower::throwValidationException('Error de Validacion', "No se encuentra el detalle");

		return $this->_construirRespuesta($cambiosAporte, $cambiosDetalle);
	}
	
	public function _editarAporte($aporte, $params, $repository)
	{
	    $cambios 		= new Cambios();
		$cambiosEnviados= $cambios->mapearComoCambios($params,array('aporte_total'));
		$cambiosAporte  = $cambios->cambiar($aporte, $cambiosEnviados);

		return $repository->persistirCambiosADatos($cambiosAporte, $aporte, 'ap_aporte', 'ap_aporte_id');
	}
	
	public function _editarDetalle($detalle, $params, $repository)
	{
	    $cambios 		= new Cambios();
		$cambiosEnviados= $cambios->mapearComoCambios($params,array('monto',
																	    	    'fecha',
																	    	    'descripcion',
																	    	    'ap_aporte_tipo_id',
																	    		'cont_moneda_id',
																	    		'org_parte_rol_socio_id'));
		$cambiosDetalle = $cambios->cambiar($detalle, $cambiosEnviados);

		return $repository->persistirCambiosADatos($cambiosDetalle, $detalle, 'ap_aporte_detalle', 'ap_aporte_detalle_id');
	}

	public function _construirRespuesta($cambiosAporte,$cambiosDetalle)
	{
		$cambios = new Cambios;
		
		return array(
			'status'  => true,
			'mensaje' => 'Aporte editado exitosamente',
			'datos'   => array(
				'campos_modificados_aporte' 	=> $cambios->getCamposCambiados($cambiosAporte),
				'campos_modificados_detalle' 	=> $cambios->getCamposCambiados($cambiosDetalle),		
			) 	
		);
	}
}