<?php

namespace Actividad\Actividad\Service\Formadores;

use EnterpriseSolutions\Db\Select as DbSelect;
use EnterpriseSolutions\Exceptions\Thrower;

class SelectFormadores extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('aaf' => 'act_actividad_formadores'));
	}
	
	public function addSearchByActividad($id)
	{
		if (!$id) {
			Thrower::throwValidationException('Error de Validacion', 'No se encuentra la actividad');
		}
		
		$this->_select
			 ->where("aaf.act_actividad_id = $id");
	}
}