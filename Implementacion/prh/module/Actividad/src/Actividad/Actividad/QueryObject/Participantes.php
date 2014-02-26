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
             ->columns(array('act_actividad_participantes_id', 'act_actividad_id', 'cont_moneda_id',
                 'org_parte_rol_id', 'monto_participante', 'se_imprimio_certificado',
                 'se_entrego_certificado', 'fecha_entrega_certificado'))
             
             ->join(array('opr' => 'org_parte_rol'), 'aap.org_parte_rol_id = opr.org_parte_rol_id', array())
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'))
             ->join(array('cm' => 'cont_moneda'), 'aap.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'simbolo'));
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
}