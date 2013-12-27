<?php

namespace Actividad\ActividadTipo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aat' => 'act_actividad_tipo'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aat.act_actividad_tipo_id = $id");
        }
    }
}