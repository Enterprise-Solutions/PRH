<?php

namespace Aporte\Aporte\Service\Get;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as DbSelect;

class GetPersona extends DbSelect
{
    
    public function _init()
    {
        $_s = ",!";
        $this->_select
             ->from(array('op' => 'org_parte'))
             ->columns(
                array('org_parte_id', 
                'persona' => new Expression("op.nombre_persona||' '||op.apellido_persona"),
                'roles'   => new Expression("string_agg(distinct 
                                            'org_parte_rol_id:'||opr.org_parte_rol_id||
                                            '{$_s}rol:'||rol.nombre||
                                            '{$_s}rol_socio:'||rst.nombre,';*')")
                ))
             ->join(
                array('opr' => 'org_parte_rol'), 
                'op.org_parte_id = opr.org_parte_id',
                array(),
                ZFSelect::JOIN_LEFT
               )
             ->join(
                array('rol' => 'org_rol'), 
                'opr.org_rol_codigo = rol.org_rol_codigo',
                array(),
                ZFSelect::JOIN_LEFT
               )
             ->join(
                array('rs' => 'org_parte_rol_socio'), 
                'opr.org_parte_rol_id = rs.org_parte_rol_id',
                array(),
                ZFSelect::JOIN_LEFT
               )   
             ->join(
                array('rst' => 'org_parte_rol_socio_tipo'), 
                'rs.org_parte_rol_socio_tipo_id = rst.org_parte_rol_socio_tipo_id',
                array(),
                ZFSelect::JOIN_LEFT
               )                                        
             ->group('op.org_parte_id');
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("op.org_parte_id = $id");
        }
    }
}