<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Partes extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('opr' => 'org_parte_rol'))
             ->columns(array('org_parte_rol_id'))
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre' => 'nombre_persona', 'apellido' => 'apellido_persona'));
    }
    
    public function addSearchByTipo($tipo)
    {
        switch ($tipo) {
        	case 'all':
        	    $this->_select
        	         ->where("(opr.org_rol_codigo = 'formador' OR opr.org_rol_codigo = 'participante')");
        	    break;
        	default:
        	    $this->_select
        	         ->where("(opr.org_rol_codigo = '$tipo')");
    	        break;
        }
    }
    
    public function addSearchByActividad($actividad)
    {
        if ($actividad) {
            $partesDeActividad = "
                SELECT opr.org_parte_rol_id
                FROM act_actividad_formadores aaf
                INNER JOIN org_parte_rol opr ON aaf.org_parte_rol_id = opr.org_parte_rol_id
                INNER JOIN org_parte op ON opr.org_parte_id = op.org_parte_id
                WHERE aaf.act_actividad_id = $actividad
                    
                    UNION
                    
                SELECT opr.org_parte_rol_id
                FROM act_actividad_participantes aap
                INNER JOIN org_parte_rol opr ON aap.org_parte_rol_id = opr.org_parte_rol_id
                INNER JOIN org_parte op ON opr.org_parte_id = op.org_parte_id
                WHERE aap.act_actividad_id = $actividad
            ";
            
            $this->_select
                 ->where("opr.org_parte_rol_id NOT IN ($partesDeActividad)");
        }
    }
}