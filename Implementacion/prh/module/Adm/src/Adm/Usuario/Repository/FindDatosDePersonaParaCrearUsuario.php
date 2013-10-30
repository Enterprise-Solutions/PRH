<?php

namespace Adm\Usuario\Repository;

use EnterpriseSolutions\Db\Select;
use Zend\Db\Sql\Select as ZFSelect;
use Zend\Db\Sql\Expression;

class FindDatosDePersonaParaCrearUsuario extends Select
{
	public function _init()
	{
		$this->_select
			 ->from(array('op' => 'org_parte'))
			 ->columns(array(
				'org_parte_id','org_parte_tipo_codigo',
				'nombre' => 'nombre_persona',
				'apellido' => 'apellido_persona',
			 	'documentos' => new Expression("string_agg(distinct od.org_documento_id::text,',')"),	
			 	//'documentos_de_usuario' => new Expression("string_agg(od.org_documento_id::text,',')")	
				//'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' "),
			 	'documentos_de_usuario' => new Expression("count(au.adm_usuario_id)"), 
		))
		//->join(array('od' => 'org_documento'),new Expression('op.org_parte_id = od.org_parte_id and od.preferencia = 1'),array('org_documento_id'),ZFSelect::JOIN_LEFT)
	    ->join(array('od' => 'org_documento'),'op.org_parte_id = od.org_parte_id',array(),ZFSelect::JOIN_LEFT)
		->join(array('dp' => 'dir_pais'),'od.dir_pais_id = dp.dir_pais_id',array(),ZFSelect::JOIN_LEFT)
		->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array(),ZFSelect::JOIN_LEFT)
		->join(array('odu' => 'org_documento'),'op.org_parte_id = odu.org_parte_id',array(),ZFSelect::JOIN_LEFT)
		->join(array('au'  => 'adm_usuario'),'odu.org_documento_id = au.org_documento_id',array(),ZfSelect::JOIN_LEFT)
		//->where("op.org_parte_tipo_codigo = 'per'")
		->group(array('op.org_parte_id','op.nombre_persona','op.apellido_persona','org_parte_tipo_codigo'));
	}
	
	public function addSearchByOrgParteId($orgParteId)
	{
		$this->_select->where("op.org_parte_id = $orgParteId");
	}
}