<?php

namespace Calendario\Service\Listado;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
             ->from('cal_anho_formacion')
             ->columns(array('cal_anho_formacion_id', 'org_parte_rol_centro', 'anho', 'fecha_inicio', 'fecha_fin', 'descripcion', 'actual' => new Expression(" case when actual = 'S' then 'Si' else 'No' end")));
	
	}
	
}