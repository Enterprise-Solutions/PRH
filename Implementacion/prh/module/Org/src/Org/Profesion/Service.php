<?php

namespace Org\Profesion;
require_once "Collection.php";
use Org\Profesion\Collection as f;
use Org\Profesion\Repository;
use Org\Profesion\Profesion;

class Service
{
	public $_repository;
	public $_respuesta;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	/**
	 * @param array $datos
	 * {
	 *  org_parte:\Org\Documento\Parte\Parte,
	 *  Profesiones{
	 *   agregados:[{},{}],editados:[{},{}],borrados:[]
	 *  }
	 * }
	 */
	public function ejecutar($datos)
	{
		$datos = array_merge_recursive(
				array('Profesiones' => array(
						'agregados' => array(),
						//'editados'  => array(),
						'borrados'  => array()
				)),
				$datos
		);
		$parte = $datos['org_parte'];
		$datosDeProfesiones = $datos['Profesiones'];
		$profesiones  = $this->_repository->findProfesionesDeParte($parte);
		
		$agregados = f\crearElementos(
				$datosDeProfesiones['agregados'], 
				$this->_crearFactoryFunction($parte)
		);
		
		//$getElemento = f\crearGetElementoFunction('org_parte_profesion_id', $profesiones);
		
		/*$editados = f\editarElementos(
				$datosDeProfesiones['editados'], 
				$profesiones, 
				$this->_crearEditarFunction(),
				$getElemento);*/
		
		$borrados = f\getElementos($profesiones, $datosDeProfesiones['borrados'],f\crearGetElementoIdFunction('getOrgProfesionId'));
		$profesiones = f\removerElementos($profesiones, $borrados, f\crearGetElementoIdFunction('getOrgProfesionId'));
		$this->_repository->persistir($agregados);
		//$this->_repository->persistir($editados);
		if($borrados){
			$this->_repository->borrar($borrados);
		}
		$this->_setRepuesta($agregados,/*$editados,*/$borrados);
	}
	
	public function _crearFactoryFunction($parte)
	{
		return function($datosDeElemento)use($parte){
			$orgProfesionId = $datosDeElemento['org_profesion_id'];
			$profesion = new Profesion($orgProfesionId);
			$profesion->setParte($parte);
			return $profesion;	
		};		
	}
	
	public function _crearEditarFunction()
	{
		return function($datosParaElemento,$elemento){
			$elemento->editar($datosParaElemento);
			return $elemento;
		};
	}

	public function _setRepuesta($agregados = array(),$editados = array(),$borrados = array())
	{
		$mapFunction = function($documento){return $documento->toArray();};
		$respuesta = array(
				'agregados' => array_map($mapFunction,$agregados),
				'editados' => array_map($mapFunction,$editados),
				'borrados' => array_map($mapFunction,$borrados)
		);
		//Excluye los vacios, los que no fueron realizados por el servicio
		$this->_respuesta = array_filter($respuesta);
	}
	
	public function getRespuesta()
	{
		return $this->_respuesta;
	}
}