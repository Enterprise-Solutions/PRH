<?php

namespace Org\Profesion;
use Org\Parte\Parte;
use Doctrine\ORM\EntityManager;

class Repository
{
	/**
	 * @var EntityManager
	 */
	public $_em;
	
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	public function findProfesionesDeParte(Parte $parte)
	{
		$profesiones = $this->_em
							->getRepository('Org\Profesion\Profesion')
							->findBy(array('org_parte_id' => $parte->getId()));
		return $profesiones;
	}
	
	public function persistir($entidades)
	{
		$em = $this->_em;
		return array_map(
				function($entidad) use ($em){
					$em->persist($entidad);
					return $entidad;
				}, $entidades
		);
		//return array_map($this->_em->persist($entidad);
	}
}