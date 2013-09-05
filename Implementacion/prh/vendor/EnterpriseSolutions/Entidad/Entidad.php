<?php
namespace EnterpriseSolutions\Entidad;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;

class Entidad
{
	public function getId()
	{
		return $this->id;
	}
	
	public function crear($datos)
	{
		$this->_hydrado($datos);
	}
	
	public function editar($datos)
	{
		$this->_hydrado($datos);
	}
	
	public function _hydrado($datos)
	{
		$hydrator = new Hydrator();
		return $hydrator->hydrate($datos, $this);
	}
}