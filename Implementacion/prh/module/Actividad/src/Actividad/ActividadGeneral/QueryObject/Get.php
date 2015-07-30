<?php

namespace Actividad\ActividadGeneral\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect {

 	public function _init()
    {
        $this->_select
             ->from(array('aag' => 'act_actividad_general'));
    }

    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aag.act_actividad_general_id = $id");
        }
    }  

}
