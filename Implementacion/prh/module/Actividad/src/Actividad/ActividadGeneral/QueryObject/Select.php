<?php

namespace Actividad\ActividadGeneral\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect {

 	public function _init()
    {
        $this->_select
             ->from(array('aag' => 'act_actividad_general'))
             ->columns(array('act_actividad_general_id', 'fecha', 'duracion', 'motivo', 'lugar'));
    }

    public function addSearchByMotivo ($motivo)
    {
    	if($motivo && $motivo != ""){
			$this->_select
	    		 ->where("aag.motivo ~* '$motivo'");
    	}
    }

    public function addSearchByFecha ($fecha)
    {
        if ($fecha && $fecha != "") {
            $this->_select
                 ->where("aag.fecha = '$fecha'");
        }
    }    

}
