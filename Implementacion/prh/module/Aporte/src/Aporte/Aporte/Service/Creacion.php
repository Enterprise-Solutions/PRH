<?php

namespace Aporte\Aporte\Service;

use Aporte\Aporte\Repository;

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
		$params['Aporte']['ap_aporte_id'] 			= $this->_crearAporte($params['Aporte'], $this->_repository);
		$params['Detalle']['ap_aporte_id'] 			= $params['Aporte']['ap_aporte_id'];
		$params['Detalle']['ap_aporte_detalle_id']	= $this->_crearDetalle($params['Detalle'], $this->_repository);
		return $this->_construirRespuesta($params);
	}

	public function _crearAporte($params,$repository)
	{
		$cambios 			= new Cambios();
        $cambiosEnviados    = $cambios->mapearComoCambios($params,array('cont_ejercicio_fiscal_id', 'aporte_total'));
		$cambiosAporte 		= $cambios->cambiar(array(), $cambiosEnviados);
        $cambiosAporteId    = $repository->persistirCambiosADatos($cambiosAporte, array(),'ap_aporte', 'ap_aporte_id');
		
		return $cambios->getValorNuevo($cambiosAporteId, 'ap_aporte_id');
	}

	public function _crearDetalle($params,$repository)
	{
		$cambios            = new Cambios();
        $cambiosEnviados    = $cambios->mapearComoCambios($params,
        												  array('org_parte_rol_cargador_id', 
        												  	    'cont_moneda_id', 
        												  	    'ap_aporte_tipo_id', 
        												  	    'ap_aporte_id', 
        												  	    'org_parte_rol_socio_id', 
        												  	    'fecha',
        												  	    'monto',
        												  	    'descripcion'));
		$cambiosDetalle 	= $cambios->cambiar(array(), $cambiosEnviados);
        $cambiosAnhoId      = $repository->persistirCambiosADatos($cambiosDetalle, array(),'ap_aporte_detalle', 'ap_aporte_detalle_id');
		
		return $cambios->getValorNuevo($cambiosAnhoId, 'ap_aporte_detalle_id');
	}
	
	public function _construirRespuesta($params)
	{
		return array(
			'status' => true,
			'mensaje' => 'Aporte creado Exitosamente',
			'datos'   => array(
				'ap_aporte_id' 			=> $params['Aporte']['ap_aporte_id'],
				'ap_aporte_detalle_id' 	=> $params['Detalle']['ap_aporte_detalle_id']
			)	
		);
	}
}