<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             ->columns(array('act_actividad_id', 'fecha_inicio', 'fecha_fin',
                 'nombre_identificador', 'duracion', 'estado', 'monto',
                 'observaciones', 'tipo', 'nro_personas'))
             
             ->join(array('aat' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = aat.act_actividad_tipo_id', array('act_actividad_tipo_id', 'actividad_tipo' => 'nombre'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('cont_moneda_id', 'moneda' => 'nombre'))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('cal_anho_formacion_id', 'anho_formacion' => 'anho'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aa.act_actividad_id = $id");
        }
    }
}