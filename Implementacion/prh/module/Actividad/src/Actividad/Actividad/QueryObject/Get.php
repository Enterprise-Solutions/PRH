<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             
             ->join(array('aat' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = aat.act_actividad_tipo_id', array('act_actividad_tipo_id', 'actividad_tipo' => 'titulo'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('cont_moneda_id', 'moneda' => 'nombre', 'precio' => new Expression("cm.simbolo || ' ' || aa.monto_referencial	")))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('cal_anho_formacion_id', 'anho_formacion' => 'anho'))
        	 ->join(array('ac' => 'act_ciclo'), 'aa.act_ciclo_id = ac.act_ciclo_id', array('act_ciclo_id', 'ciclo' => 'nombre'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aa.act_actividad_id = $id");
        }
    }
}