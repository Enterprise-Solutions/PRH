<?php

namespace Calendario\Calendario\Service;

use Calendario\Calendario\Repository;

class Borrado
{
	public $_repository;

	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{
		$rs 		= $this->_repository->findCalendario($params);
		if($rs)
		{
			$self 		= $this;
			$borrados 	= array_map(
							function($datosCalendario) use($self){
								return $self->borrarCalendario($datosCalendario);
							}, 
							$rs
						);

			return $this->_construirRespuesta($rs);	
		}else{
			return array(
				'status'  => false,
				'mensaje' => 'El año académico seleccionado no puede ser borrado',
			);
		}
			
		
	}
	
	public function borrarCalendario($rowCalendario)
	{
		$calendario = array_intersect_key(
						$rowCalendario,
						array_flip(array('cal_anho_formacion_id','org_parte_rol_centro','anho','fecha_inicio','fecha_fin', 'descripcion', 'actual'))
					);

		return $this->_repository->borrar($calendario, 'cal_anho_formacion', 'cal_anho_formacion_id');
	}
	
	public function _construirRespuesta($rs)
	{
		$idsBorrados = array();
		$idsBorrados = array_reduce(
			$rs, 
			function($idsBorrados,$row){
				$idsBorrados[] = $row['cal_anho_formacion_id'];
				return $idsBorrados;
			},
			$idsBorrados
		);
		return array(
				'status'  => true,
				'mensaje' => 'Borrado de calendario exitoso',
				'datos'   => array(
					'borrados' => $idsBorrados
				)
		);
	}
}