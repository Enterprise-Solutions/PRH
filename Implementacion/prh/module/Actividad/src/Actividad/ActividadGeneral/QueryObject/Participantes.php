<?php

namespace Actividad\ActividadGeneral\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Participantes extends DbSelect {

 	public function _init()
    {
        $this->_select
             ->from(array('aagp' => 'act_actividad_general_participantes'));
    }

    public function addSearchByActividad($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("aagp.act_actividad_general_id = $id");
        }
    }  

}
