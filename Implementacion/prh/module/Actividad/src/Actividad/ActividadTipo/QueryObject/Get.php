<?php

namespace Actividad\ActividadTipo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aat' => 'act_actividad_tipo'))
             ->columns(array('act_actividad_tipo_id', 'nombre', 'codigo', 'subtitulo', 'atelier',
                 'asistencia', 'duracion', 'fecha_baja', 'fecha_alta'))
             
             ->join(array('an' => 'act_nivel'), 'aat.act_nivel_id = an.act_nivel_id', array('act_nivel_id', 'nivel' => 'nombre'))
             ->join(array('am' => 'act_modalidad'), 'aat.act_modalidad_id = am.act_modalidad_id', array('act_modalidad_id', 'modalidad' => 'nombre'))
             ->join(array('ac' => 'act_criterio'), 'aat.act_criterio_id = ac.act_criterio_id', array('act_criterio_id', 'criterio' => 'codigo'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aat.act_actividad_tipo_id = $id");
        }
    }
}