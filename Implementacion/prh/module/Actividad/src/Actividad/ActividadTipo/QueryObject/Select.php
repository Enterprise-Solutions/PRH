<?php

namespace Actividad\ActividadTipo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aat' => 'act_actividad_tipo'))
             ->columns(array('act_actividad_tipo_id', 'nombre', 'codigo', 'atelier', 'asistencia', 'duracion'))
             
             ->join(array('an' => 'act_nivel'), 'aat.act_nivel_id = an.act_nivel_id', array('nivel' => 'nombre'))
             ->join(array('am' => 'act_modalidad'), 'aat.act_modalidad_id = am.act_modalidad_id', array('modalidad' => 'nombre'))
             ->join(array('ac' => 'act_criterio'), 'aat.act_criterio_id = ac.act_criterio_id', array('criterio' => 'codigo'));
    }
    
    public function addSearchByNombre($nombre)
    {
        if ($nombre && $nombre != "") {
            $this->_select
                 ->where("aat.nombre ILIKE '%$nombre%'");
        }
    }
    
    public function addSearchByCodigo($codigo)
    {
        if ($codigo && $codigo != "") {
            $this->_select
                 ->where("aat.codigo ILIKE '%$codigo%'");
        }
    }
    
    public function addSearchByNivel($nivel)
    {
        if ($nivel && $nivel != "") {
            $this->_select
                 ->where("aat.act_nicel_id = $nivel");
        }
    }
    
    public function addSearchByModalidad($modalidad)
    {
        if ($modalidad && $modalidad != "") {
            $this->_select
                 ->where("aat.act_modalidad_id = $modalidad");
        }
    }
    
    public function addSearchByCriterio($criterio)
    {
        if ($criterio && $criterio != "") {
            $this->_select
                 ->where("aat.act_criterio_id = $criterio");
        }
    }
}