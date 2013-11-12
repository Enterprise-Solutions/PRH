<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use EnterpriseSolutions\Exceptions\Thrower;

class Participantes extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aap' => 'act_actividad_participantes'))
             ->columns(array('act_actividad_participantes_id'))
             ->join(array('opr' => 'org_parte_rol'), 'aap.org_parte_rol_id = opr.org_parte_rol_id', array())
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'));
    }
    
    public function addSearchByActividad($id = 'no_id')
    {
        if ($id != 'none') {
        	$this->_select
        	     ->where("aap.act_actividad_id = $id");
        } else {
            Thrower::throwValidationException('Error de Validacion', 'No se especifico la actividad para listar los participantes');
        }
    }
    
    public function addSearchByParte($participante)
    {
        if ($participante && $participante != "") {
            $this->_select
                 ->where("(op.nombre || ' ' || op.apellido) ILIKE '%$participante%'");
        }
    }
}