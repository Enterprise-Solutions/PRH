<?php

namespace Actividad\ActividadGeneral\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Partes extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('op' => 'org_parte'))
             ->columns(array('org_parte_id', 'nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'))
             ->where("op.org_parte_tipo_codigo = 'per'");
    }
       
    public function addSearchByActividad($actividad)
    {
        if ($actividad) {
            $partesDeActividad = "
                    SELECT DISTINCT op.org_parte_id
                    FROM act_actividad_general_participantes aagp
                    INNER JOIN org_parte_rol opr ON aagp.org_parte_rol_id = opr.org_parte_rol_id
                    INNER JOIN org_parte op ON opr.org_parte_id = op.org_parte_id
                    WHERE aagp.act_actividad_general_id = $actividad
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