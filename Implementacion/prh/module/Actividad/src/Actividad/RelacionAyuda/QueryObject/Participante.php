<?php

namespace Actividad\RelacionAyuda\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Participante extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aap' => 'act_actividad_participantes'))
             ->columns(array())
             
             ->join(array('apa' => 'act_participante_anonimo'), 'aap.act_participante_anonimo_id = apa.act_participante_anonimo_id', array('act_participante_anonimo_id', 'identificador', 'alias', 'descripcion'))
             ->join(array('aaf' => 'act_actividad_formadores'), 'aap.act_actividad_formadores_id = aaf.act_actividad_formadores_id', array())
             ->join(array('opr' => 'org_parte_rol'), 'aaf.org_parte_rol_id = opr.org_parte_rol_id', array())
             
             ->where("opr.org_rol_codigo = 'formador'");
    }
    
    public function addSearchByIdentificador($identificador)
    {
        if ($identificador) {
            $this->_select
                 ->where("apa.identificador ILIKE '$identificador-%'");
        }
    }
    
    public function addSearchByAlias($alias)
    {
        if ($alias && $alias != '') {
            $this->_select
                 ->where("apa.alias ILIKE '%$alias%'");
        } else {
            $this->_select
                 ->where("apa.alias ILIKE '%gu%'");
        }
    }
}