<?php

namespace Actividad\RelacionAyuda\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZfSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $recaudacion = new Expression("coalesce(sum(aap.monto_participante),0)");
        
        $this->_select
             // Actividad
             ->from(array('aa' => 'act_actividad'))
             
             // Detalles de la actividad
             ->join(array('aat' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = aat.act_actividad_tipo_id', array('actividad_tipo' => 'titulo', 'modalidad'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre', 'precio' => new Expression("cm.simbolo || ' ' || aa.monto_referencial")))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('anho_formacion' => 'anho'))
             ->join(array('ac' => 'act_ciclo'), 'aa.act_ciclo_id = ac.act_ciclo_id', array('ciclo' => 'nombre'))
             
             // Formadores
             ->join(array('aaf' => 'act_actividad_formadores'), 'aa.act_actividad_id = aaf.act_actividad_id', array('act_actividad_formadores_id'), ZfSelect::JOIN_LEFT)
             ->join(array('opr' => 'org_parte_rol'), 'aaf.org_parte_rol_id = opr.org_parte_rol_id', array('org_parte_rol_id'), ZfSelect::JOIN_LEFT)
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('formador' => new Expression("nombre_persona || ' ' || apellido_persona")), ZfSelect::JOIN_LEFT)
             
             // Participantes
             ->join(array('aap' => 'act_actividad_participantes'), 'aa.act_actividad_id = aap.act_actividad_id', array('recaudacion' => $recaudacion), ZfSelect::JOIN_LEFT)
             
             ->where("aat.relacion_ayuda = 'S'")
             
             ->group(array(
                 'aa.act_actividad_id', 'aa.act_actividad_tipo_id', 'aa.cont_moneda_id', 'aa.cal_anho_formacion_id',
                 'aa.act_ciclo_id', 'aa.titulo', 'aa.fecha_inicio', 'aa.fecha_fin', 'aa.duracion', 'aa.monto_referencial',
                 'aa.nro_personas', 'aa.requiere_certificado', 'aa.observaciones', 'aa.atelier', 'aa.asistencia',
                 'aa.modalidad_act', 'aa.codigo', 'aat.titulo', 'aat.modalidad', 'cm.nombre', 'cm.simbolo',
                 'caf.anho', 'ac.nombre', 'aaf.act_actividad_formadores_id', 'opr.org_parte_rol_id',
                 'op.nombre_persona', 'op.apellido_persona'
             ));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aa.act_actividad_id = $id");
        }
    }
}