<?php

namespace Actividad\RelacionAyuda\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Select as ZfSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             ->columns(array('act_actividad_id', 'fecha_inicio', 'fecha_fin',
                 'duracion', 'monto_referencial', 'modalidad_act'))
             
             ->join(array('act' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = act.act_actividad_tipo_id', array('actividad_tipo' => 'titulo', 'modalidad'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'simbolo'))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('anho_formacion' => 'anho'))
             
             // Participante
             ->join(array('aap' => 'act_actividad_participantes'), 'aa.act_actividad_id = aap.act_actividad_id', array(), ZfSelect::JOIN_LEFT)
             ->join(array('apa' => 'act_participante_anonimo'), 'aap.act_participante_anonimo_id = apa.act_participante_anonimo_id', array('identificador', 'alias'))
             
             ->where("act.relacion_ayuda = 'S'");
    }
    
    public function addSearchByCiclo($act_ciclo_id)
    {
        if ($act_ciclo_id) {
            $this->_select
                 ->where("aa.act_ciclo_id = $act_ciclo_id");
        }
    }
    
    public function addSearchByTitulo($titulo)
    {
        if ($titulo && $titulo != "") {
            $this->_select
                 ->where("aa.titulo ILIKE '%$titulo%'");
        }
    }
    
    public function addSearchByAlias($alias)
    {
        if ($alias && $alias != "") {
            $this->_select
                 ->where("apa.alias ILIKE '%$alias%'");
        }
    }
    
    public function addSearchByIdentificador($identificador)
    {
        if ($identificador && $identificador != "") {
            $this->_select
                 ->where("apa.identificador ILIKE '%$identificador%'");
        }
    }
    
    public function addSearchByFecha($fecha)
    {
        if ($fecha && $fecha != "") {
            $this->_select
                 ->where("aa.fecha_inicio = '$fecha'");
        }
    }
}