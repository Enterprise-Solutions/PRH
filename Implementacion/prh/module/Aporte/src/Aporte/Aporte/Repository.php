<?php

namespace Aporte\Aporte;

use Zend\Db\Adapter\Adapter;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;

use Aporte\Aporte\Service\Listado\SelectAportes as SelectDeAportes;

class Repository extends EsRepository
{
	
	public function getAporte($aporteId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeAportes($dbAdapter);
		$select->addSearchByAporteId($aporteId);
		$rs 		= $select->execute()->toArray();
		
		if(count($rs) <= 0){
			return false;
		}

		return current($rs);
	}

	public function getDetalle($detalleId)
	{
		$dbAdapter 	= $this->_ds->_getDbConnection();
		$select 	= new SelectDeAportes($dbAdapter);
		$select->addSearchByDetalleId($detalleId);
		$rs 		= $select->execute()->toArray();
		
		if(count($rs) <= 0){
			return false;
		}

		return current($rs);
	}
		

	
}
