<?php

namespace Org\Parte\Service;

use EnterpriseSolutions\Exceptions\Thrower;

//use Org\Parte\Repository;
use Org\Parte\Service\Borrado\Repository;
use \Exception;

class Borrado
{
	public $_repository;
	public $_resultado = array();
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{
		$partes = $this->_repository->findPartes($params);
		$idBorrados = array();
		foreach($partes as $parte){
			$idBorrados[] = $this->_borrarParte($parte);
		}
		return $this->_construirRespuesta($idBorrados);
	}
	
	public function _borrarParte($datos)
	{
		try{
			foreach($datos['documentos'] as $documento){
				$this->_repository->borrar($documento, 'org_documento', 'org_documento_id');
			}
			foreach($datos['contactos'] as $contacto){
				$this->_repository->borrar($contacto, 'org_contacto', 'org_contacto_id');
			}
			foreach($datos['direcciones'] as $direccion){
				$this->_repository->borrar($direccion, 'dir_direccion', 'dir_direccion_id');
			}
			$this->_repository->borrar($datos['org_parte'], 'org_parte', 'org_parte_id');
			return $datos['org_parte']['org_parte_id'];
		}catch(Exception $e){
			Thrower::throwValidationException(null,array("La parte {$datos['org_parte']['org_parte_id']} tiene dependencias, no puede ser borrada"));
		}
	}
	
	public function _construirRespuesta($idBorrados)
	{
		return array(
			'status' => true,
			'mensaje' =>'Borrado de Parte/s exitoso',
			'datos' => array('org_parte_id' => $idBorrados)
		);
	}
	
	/*public function ejecutar($ids)
	{
		$partes = $this->_repository->find($ids);
		foreach($partes as $parte){
			$this->_repository->borrar($parte);
			$this->_agregarAResultado($parte);
		}
		return $partes;
	}
	
	public function _agregarAResultado($parte)
	{
		$this->_resultado[] = $parte->toArray();
	}
	
	public function getRespuesta()
	{
		return $this->_resultado;
	}*/
	
	
}