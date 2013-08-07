<?php
namespace Actividad\Actividad\QueryObject;
use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
		->from(array('aa' => 'act_actividad'))
		->columns(array('act_actividad_id', 'fecha_inicio', 'fecha_fin', 'nombre_identificador', 'duracion', 'estado', 'monto',
				'observaciones','tipo','nro_personas'))
		->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('nombre'))
		->join(array('act' => 'act_actividad_tipo'), 'act.act_actividad_tipo_id = aa.act_actividad_tipo_id', array('nombre_act_tipo' => 'nombre'))
		->join(array('caf' => 'cal_anho_formacion'), 'caf.cal_anho_formacion_id = aa.cal_anho_formacion_id', array('anho'));
	}
	
}