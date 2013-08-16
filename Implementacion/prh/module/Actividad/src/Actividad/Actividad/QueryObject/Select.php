<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
	public function _init()
	{
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             ->columns(array('act_actividad_id', 'fecha_inicio', 'fecha_fin',
                 'nombre_identificador', 'duracion', 'estado', 'monto', 'tipo',
                 'observaciones', 'nro_personas'))
             
             ->join(array('act' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = act.act_actividad_tipo_id', array('actividad_tipo' => 'nombre'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre'))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('anho_formacion' => 'anho'));
	}
}