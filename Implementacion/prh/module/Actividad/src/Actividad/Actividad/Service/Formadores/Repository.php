<?php

namespace Actividad\Actividad\Service\Formadores;

use Actividad\Actividad\Service\Formadores\SelectFormadores as Select;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;

class Repository extends EsRepository
{
	public function find($actividadId)
	{
		$select = new Select($this->_ds->_getDbConnection());
		$select->addSearchByActividad($actividadId);
		
		$records = $select->execute()->toArray();
		if (count($records) == 0) {
			return false;
		}
		return $records;
	}
}