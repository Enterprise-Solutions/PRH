<?php

namespace Calendario\Calendario\Service\Listado;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
             ->from('cal_anho_formacion')
             ->columns(array('cal_anho_formacion_id', 
             				 'org_parte_rol_centro', 
             				 'anho', 
             				 'fecha_inicio', 
             				 'fecha_fin', 
             				 'descripcion', 
             				 'actual', 
             				 'es_actual' => new Expression(" case when actual = 'S' then 'Si' else 'No' end")
             				 )
        );
	}

	public function addSearchByCalAnhoFormacionId($calAnhoFormacionId)
	{
		$this->_select
		     ->columns(array(
				'cal_anho_formacion_id',
				'org_parte_rol_centro',
		     	'anho',
				'fecha_inicio', 
				'fecha_fin', 
				'descripcion', 
				'actual', 
		    ))
			->where("cal_anho_formacion_id = $calAnhoFormacionId");
	}

	public function getCalendariosNoActuales($calAnhoFormacionId)
	{
		$this->_select
			 ->columns(array('cal_anho_formacion_id','actual'))
			 ->where("cal_anho_formacion_id not in ($calAnhoFormacionId)");
	}
	
	public function addSearchByCalAnhoFormacionIds($calAnhoFormacionIds)
	{
		$calAnhoFormacionIds = join(',',$calAnhoFormacionIds);
		$this->_select
			 ->columns(array('cal_anho_formacion_id','org_parte_rol_centro','anho','fecha_inicio','fecha_fin', 'descripcion', 'actual'));
		$this->_select
			 ->where("cal_anho_formacion_id in ($calAnhoFormacionIds) and actual != 'S'");
	}

	public function addSearchByActividad($calAnhoFormacionId)
	{
		$id 	= $calAnhoFormacionId[0];
		$this->_select
			 ->from(array('caf' => 'cal_anho_formacion'))
			 ->join(array('aa' => 'act_actividad'), 'aa.cal_anho_formacion_id = caf.cal_anho_formacion_id')
			 ->where("aa.cal_anho_formacion_id = $id");
	}

	public function addSearchByAnho($calAnhoFormacion)
	{
		$this->_select
			 ->where("anho = $calAnhoFormacion");
	}
}