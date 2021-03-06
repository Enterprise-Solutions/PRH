<?php

namespace Actividad\Actividad\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
	public function _init()
	{
        $this->_select
             ->from(array('aa' => 'act_actividad'))
             ->columns(array('act_actividad_id', 'act_ciclo_id', 'act_actividad_tipo_id',
                 'fecha_inicio', 'fecha_fin', 'titulo', 'duracion', 'monto_referencial', 'modalidad_act'))
             
             ->join(array('act' => 'act_actividad_tipo'), 'aa.act_actividad_tipo_id = act.act_actividad_tipo_id', array('actividad_tipo' => 'titulo', 'modalidad'))
             ->join(array('cm' => 'cont_moneda'), 'aa.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'simbolo'))
             ->join(array('caf' => 'cal_anho_formacion'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id', array('anho_formacion' => 'anho'))
             ->join(array('ac' => 'act_ciclo'), 'aa.act_ciclo_id = ac.act_ciclo_id', array('ciclo' => 'nombre'))
             
             ->where("act.relacion_ayuda = 'N'");
	}
	
	public function addSearchByTitulo($titulo)
	{
	    if ($titulo && $titulo != "") {
	        $this->_select
	             ->where("aa.titulo ILIKE '%$titulo%'");
	    }
	}
	
	public function addSearchByCiclo($ciclo)
	{
	    if ($ciclo) {
	        $this->_select
	             ->where("aa.act_ciclo_id = $ciclo");
	    }
	}
	
	public function addSearchByActividadTipo($actividadTipo)
	{
	    if ($actividadTipo) {
	        $this->_select
	             ->where("aa.act_actividad_tipo_id = $actividadTipo");
	    }
	}
}