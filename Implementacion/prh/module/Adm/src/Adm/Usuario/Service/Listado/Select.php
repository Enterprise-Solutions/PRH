<?php
namespace Adm\Usuario\Service\Listado;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('au' => 'adm_usuario'))
			 ->columns(array(
			 	'adm_usuario_id',
			 	'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' "),
			 	'org_documento_id',		
			 	'estado_usuario' => new Expression(" case when estado = 'A' then 'Activo' else 'Bloqueado' end"),
			 	'estado',	
			 	'roles' => new Expression("''")
			 ))
			 ->join(array('od' => 'org_documento'),'au.org_documento_id = od.org_documento_id',array('org_parte_id'))
			 ->join(array('op' => 'org_parte'),'od.org_parte_id = op.org_parte_id',array('nombre' => 'nombre_persona','apellido' => 'apellido_persona'))
			 ->join(array('dp' => 'dir_pais'),'od.dir_pais_id = dp.dir_pais_id',array())
			 ->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array());	
	}
	
	public function addSearchByEstado($estado)
	{
		$this->_select->where("au.estado = '$estado'");
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select->where("((op.nombre_persona ~* '$nombre') or (op.apellido_persona ~* '$nombre') or (od.valor ~* '$nombre'))");
	}
	
	public function addSearchByAdmUsuarioId($admUsuarioId)
	{
		$this->_select
		     ->columns(array(
				'adm_usuario_id',
				'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' "),
		     	'org_documento_id', //=> new Expression("od.org_documento_id"),
				'estado_usuario' => new Expression(" case when estado = 'A' then 'Activo' else 'Bloqueado' end"),
				'estado',
				//'roles' => new Expression("''")
		     	'documentos_de_usuario' => new Expression("string_agg(distinct odp.org_documento_id::text,',')")
		    ))
		    ->join(array('odp' => 'org_documento'), 'op.org_parte_id = odp.org_parte_id',array())
			->where("au.adm_usuario_id = $admUsuarioId")
			->group(array('au.adm_usuario_id','documento_identidad','od.org_documento_id','estado_usuario','estado','nombre_persona','apellido_persona'));
	}
	
	public function addSearchByAdmUsuarioIds($admUsuarioIds)
	{
		$admUsuarioIds = join(',',$admUsuarioIds);
		$this->_select
			 ->columns(array(
			 	'adm_usuario_id',
			 	'org_documento_id',
			 	'contrasenha',
			 	'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' "),	
			 	'estado_usuario' => new Expression(" case when estado = 'A' then 'Activo' else 'Bloqueado' end"),
			 	'estado',));
		$this->_select
			 ->where("au.adm_usuario_id in ($admUsuarioIds)");
	}
	
	public function addSearchById($id)
	{
		$this->addSearchByAdmUsuarioId($id);
	}
}