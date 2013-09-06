<?php

namespace Org\Parte\Service\Borrado;

use EnterpriseSolutions\Db\Select as EsSelect;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('op' => 'org_parte')) 			 
			 ->columns(
			 	array(
			 		'op_org_parte_id' => 'org_parte_id',
			 		'op_org_parte_tipo_codigo' => 'org_parte_tipo_codigo',
			 		'op_org_religion_id' => 'org_religion_id',
			 		'op_org_estado_civil_id' => 'org_estado_civil_id',
			 		'op_nombre_organizacion' => 'nombre_organizacion',
			 		'op_nombre_persona' => 'nombre_persona',
			 		'op_apellido_persona' => 'apellido_persona',
			 		'op_fecha_nacimiento' => 'fecha_nacimiento',
			 		'op_genero_persona' => 'genero_persona',
			 		'op_nro_hijos' => 'nro_hijos',
			 		'op_sobrenombre' => 'sobrenombre',
			 		'op_nacionalidad_persona' => 'nacionalidad_persona' 
			 	)
			 )
				->join(
					array('od' => 'org_documento'),
			 		"op.org_parte_id = od.org_parte_id",
			 		array(
			 			 'od_org_documento_id' => 'org_documento_id',
			 			 'od_org_parte_id'     => 'org_parte_id',
			 			 'od_org_documento_tipo_codigo' => 'org_documento_tipo_codigo',
			 			 'od_dir_pais_id' => 'dir_pais_id',
			 			'od_valor' => 'valor',
			 			'od_preferencia' => 'preferencia'
			 		),
					ZFSelect::JOIN_LEFT
				)
					 		->join(
					 		array('oc' => 'org_contacto'),
			 	'op.org_parte_id = oc.org_parte_id',
					 		array(
					 			'oc_org_contacto_id' => 'org_contacto_id',
					 			'oc_org_parte_id' => 'org_parte_id',
					 			'oc_org_contacto_tipo_codigo' => 'org_contacto_tipo_codigo',
					 			'oc.contacto' => 'contacto',
					 			'oc.descripcion' => 'descripcion'
					 		),
					 		ZFSelect::JOIN_LEFT
					 )
				->join(
					array('dd' => 'dir_direccion'),
			 				'op.org_parte_id = dd.org_parte_id',
								array(
									'dd_dir_direccion_id' => 'dir_direccion_id',
									'dd_dir_direccion_tipo_id' => 'dir_direccion_tipo_id',
									'dd_org_parte_id' => 'org_parte_id',
									'dd_dir_barrio_id' => 'dir_barrio_id',
									'dd.calle' => 'calle'	 	
								),
								ZFSelect::JOIN_LEFT
					 );
	}
	
	public function addSearchByOrgParteIds($orgParteIds)
	{
		$ids = join(',',$orgParteIds);
		$this->_select->where("op.org_parte_id in ($ids)");
	}
}