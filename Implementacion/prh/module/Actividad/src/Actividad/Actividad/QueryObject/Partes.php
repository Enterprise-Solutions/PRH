<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Partes extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('op' => 'org_parte'))
             ->columns(array('org_parte_id', 'nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'));
    }
    
    public function addSearchByTipo($tipo)
    {
        if ($tipo === 'formador') {
            $this->_select
                 ->join(array('opr' => 'org_parte_rol'), 'op.org_parte_id = opr.org_parte_id', array('org_parte_rol_id'))
                 ->where("(opr.org_rol_codigo = 'formador')");
        }
    }
    
    public function addSearchByActividad($actividad)
    {
        if ($actividad) {
            $partesDeActividad = "
                SELECT DISTINCT op.org_parte_id
                FROM act_actividad_formadores aaf
                INNER JOIN org_parte_rol opr ON aaf.org_parte_rol_id = opr.org_parte_rol_id
                INNER JOIN org_parte op ON opr.org_parte_id = op.org_parte_id
                WHERE aaf.act_actividad_id = $actividad
                    
                    UNION
                    
                SELECT DISTINCT op.org_parte_id
                FROM act_actividad_participantes aap
                INNER JOIN org_parte_rol opr ON aap.org_parte_rol_id = opr.org_parte_rol_id
                INNER JOIN org_parte op ON opr.org_parte_id = op.org_parte_id
                WHERE aap.act_actividad_id = $actividad
            ";
            
            $this->_select
                 ->where("op.org_parte_id NOT IN ($partesDeActividad)");
        }
    }
    
    public function addSearchByParte($parte)
    {
        if ($parte && $parte != "") {
            $this->_select
                 ->where("(op.nombre_persona || ' ' || op.apellido_persona) ILIKE '%$parte%'");
        }
    }
}