<?php

namespace Aporte\Aporte\Service;

use Aporte\Aporte\Repository;
use EnterpriseSolutions\Exceptions\Thrower;

class Borrado
{
	public $_repository;

	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{
		
		$detalle		= $this->_repository->getDetalle($params['ap_aporte_detalle_id']);
		$aporte			= $this->_repository->getAporte($params['ap_aporte_id']);

		$detalleBorrado = $this->borrarDetalle($detalle);
		$aporteBorrado 	= $this->borrarAporte($aporte);

		return $this->_construirRespuesta($detalle, $aporte);	            	
	}
	
	public function borrarDetalle($rowDetalle)
	{
		$detalle 	= array_intersect_key(
						$rowDetalle,
						array_flip(array('ap_aporte_detalle_id',
										 'org_parte_rol_cargador_id', 
								  	     'cont_moneda_id', 
								  	     'ap_aporte_tipo_id', 
								  	     'ap_aporte_id', 
								  	     'org_parte_rol_socio_id', 
								  	     'fecha',
								  	     'monto',
								  	     'descripcion')));

		try {
			$this->_repository->borrar($detalle, 'ap_aporte_detalle', 'ap_aporte_detalle_id');
		} catch (Exception $e) {
            Thrower::throwValidationException('Error de Validacion', "El aporte seleccionado no puede ser borrado");
		}
	}

	public function borrarAporte($rowAporte)
	{
		$aporte 	= array_intersect_key(
						$rowAporte,
						array_flip(array('ap_aporte_id',
										 'cont_ejercicio_fiscal_id', 
										 'aporte_total')));

		try {
			$this->_repository->borrar($aporte, 'ap_aporte', 'ap_aporte_id');
		} catch (Exception $e) {
            Thrower::throwValidationException('Error de Validacion', "El aporte seleccionado no puede ser borrado");
		}
	}

	public function _construirRespuesta($detalle, $aporte)
	{		
		return array(
				'status'  => true,
				'mensaje' => 'Borrado de aporte exitoso',
				'datos'   => array(
					'detalle_borrados' => $detalle['ap_aporte_detalle_id'] ,
					'aporte_borrados'  => $aporte['ap_aporte_id'],
				)
		);
	}
}