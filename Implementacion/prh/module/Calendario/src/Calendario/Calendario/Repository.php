<?php

namespace Calendario\Calendario;

use Zend\Db\Adapter\Adapter;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;
use Adm\Usuario\Repository\FindDatosDePersonaParaCrearUsuario as SelectDatosParaCrearUsuario;
use Adm\Usuario\Repository\SelectRequisitosDePassword;
use Calendario\Calendario\Service\Listado\Select as SelectDeCalendario;

class Repository extends EsRepository
{
	/**
	 * @param int $orgParteId
	 * @return array
	 */
	public function getDatosParaCrearCalendario($calAnhoId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDatosParaCrearUsuario($dbAdapter);
		$select->addSearchByOrgParteId($orgParteId);
		$rs 		= $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return current($rs);
	}
	
	public function getCalAnhoFormacion($calAnhoFormacionId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeCalendario($dbAdapter);
		$select->addSearchByCalAnhoFormacionId($calAnhoFormacionId);
		$rs 		= $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return current($rs);
	}
		
	public function getCalendariosActuales($calAnhoFormacionId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeCalendario($dbAdapter);
		$select->getCalendariosNoActuales($calAnhoFormacionId);
		$rs 		= $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return current($rs);
	}

	public function findCalendario($calAnhoFormacionId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeCalendario($dbAdapter);
		$select->addSearchByCalAnhoFormacionIds($calAnhoFormacionId);
		$rs 		= $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return $rs;
	}

	public function findActividades($calAnhoFormacionId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeCalendario($dbAdapter);
		$select->addSearchByActividad($calAnhoFormacionId);
		$rs 		= $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return $rs;
	}
}
