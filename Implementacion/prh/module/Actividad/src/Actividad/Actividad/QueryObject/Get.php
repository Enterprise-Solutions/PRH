<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZfSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             
             ->join(array('aat' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = aat.act_actividad_tipo_id', array('act_actividad_tipo_id', 'actividad_tipo' => 'titulo'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('cont_moneda_id', 'moneda' => 'nombre', 'precio' => new Expression("cm.simbolo || ' ' || aa.monto_referencial	")))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('cal_anho_formacion_id', 'anho_formacion' => 'anho'))
        	 ->join(array('ac' => 'act_ciclo'), 'aa.act_ciclo_id = ac.act_ciclo_id', array('act_ciclo_id', 'ciclo' => 'nombre'))
        	 ->join(array('aaf' => 'act_actividad_formadores'), 'aa.act_actividad_id = aaf.act_actividad_id', array(), ZfSelect::JOIN_LEFT)
        	 ->join(array('opr' => 'org_parte_rol'), 'aaf.org_parte_rol_id = opr.org_parte_rol_id', array(), ZfSelect::JOIN_LEFT)
        	 ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('formador' => new Expression("nombre_persona || ' ' || apellido_persona")), ZfSelect::JOIN_LEFT);
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aa.act_actividad_id = $id");
        }
    }
}