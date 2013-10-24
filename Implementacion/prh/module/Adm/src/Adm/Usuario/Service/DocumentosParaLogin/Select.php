<?php

namespace Adm\Usuario\Service\DocumentosParaLogin;
use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('od' => 'org_documento'))
			 ->columns(array(
			 	'org_documento_id',
			 	'valor'			
			 ))
			 ->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array('tipo' => 'nombre'))
			 ->join(array('dp' => 'dir_pais'),'od.dir_pais_id = dp.dir_pais_id',array('pais' => 'nombre'));
	}
	
	public function addSearchByOrgParteId($orgParteId)
	{
		$this->_select->where("od.org_parte_id = $orgParteId");
	}
}
