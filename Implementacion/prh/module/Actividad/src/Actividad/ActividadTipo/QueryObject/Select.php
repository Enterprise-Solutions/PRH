<?php

namespace Actividad\ActividadTipo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aat' => 'act_actividad_tipo'))
             ->columns(array('codigo'))
             
             ->join(array('an' => 'act_nivel'), 'aat.act_nivel_id = an.act_nivel_id', array('nivel' => 'nombre'))
             ->join(array('am' => 'act_modalidad'), 'aat.act_modalidad_id = am.act_modalidad_id', array('modalidad' => 'nombre'))
             ->join(array('ac' => 'act_criterio'), 'aat.act_criterio_id = ac.act_criterio_id', array('criterio' => 'codigo'));
    }
}