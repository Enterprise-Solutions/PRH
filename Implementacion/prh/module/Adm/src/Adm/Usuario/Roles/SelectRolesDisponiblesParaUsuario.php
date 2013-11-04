<?php

namespace Adm\Usuario\Roles;
use EnterpriseSolutions\Db\Select as EsSelect;
use Zend\Db\Sql\Select as ZFSelect;

/**
 * @author pislas
 *
 */
class SelectRolesDisponiblesParaUsuario extends EsSelect
{
	public function _init()
	{
		$this->_select
		     ->from(array('ar' => 'adm_rol'));
	}
	
	public function addSearchByAdmUsuarioId($admUsuarioId)
	{
		$this->_select
			 ->join(
			 	array('aur' => 'adm_usuario_rol'),
			 	'ar.adm_rol_id = aur.adm_rol_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT 
			 );
		$this->_select->where('aur.adm_usuario_rol_id is NULL');
	}
}