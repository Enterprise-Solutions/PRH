<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use EnterpriseSolutions\Exceptions\Thrower;

class Formadores extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aaf' => 'act_actividad_formadores'))
             ->columns(array('act_actividad_formadores_id'))
             ->join(array('opr' => 'org_parte_rol'), 'aaf.org_parte_rol_id = opr.org_parte_rol_id', array())
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'));
    }
    
    public function addSearchByActividad($id = 'no_id')
    {
        if ($id != 'none') {
        	$this->_select
        	     ->where("aaf.act_actividad_id = $id");
        } else {
            Thrower::throwValidationException('Error de Validacion', 'No se especifico la actividad para listar los formadores');
        }
    }
    
    public function addSearchByFormador($formador)
    {
        if ($formador && $formador != "") {
            $this->_select
                 ->where("(op.nombre || ' ' || op.apellido) ILIKE '%$formador%'");
        }
    }
}