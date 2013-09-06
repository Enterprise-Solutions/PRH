<?php

namespace Org\Parte\Service\Borrado;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;

use Zend\Db\Adapter\Adapter;

use Org\Parte\Service\Borrado\Select;
class Repository extends EsRepository
{	
	public function findPartes($orgParteIds)
	{	
		$select = new Select($this->_ds->_getDbConnection());
		$select->addSearchByOrgParteIds($orgParteIds);
		$rs = $select->execute()->toArray();
		$partes = array();
		
		foreach($rs as $row){
			$partes = $this->_hidrarParte($row, $partes);
		}
		return $partes;		
	}
	
	public function _hidrarParte($row,$partes)
	{
		$camposOp = $this->_getCampos($row, 'op');
		$orgParteId = $camposOp['org_parte_id'];
		if(!isset($partes[$orgParteId])){
			$partes[$orgParteId] = array(
				'org_parte' => $camposOp,
				'documentos' => array(),
				'contactos'  => array(),
				'direcciones' => array()
			);
		}
		$parte = &$partes[$orgParteId];
		$parte['documentos'] = $this->_hidrar($row, $parte['documentos'],'od','org_documento_id');
		$parte['contactos']  = $this->_hidrar($row, $parte['contactos'],'oc','org_contacto_id');
		$parte['direcciones'] = $this->_hidrar($row, $parte['direcciones'],'dd','dir_direccion_id');
		return $partes;
	}
	
	public function _hidrar($row,$entidades,$prefijo,$campoId)
	{
		$camposDeEntidad = $this->_getCampos($row, $prefijo);
		$id = $camposDeEntidad[$campoId];
		if(!$id){
			return $entidades;
		}
		
		foreach($entidades as $entidad){
			if($entidad[$campoId] == $id){
				return $entidades;
			}
		}
		$entidades[] = $camposDeEntidad;
		return $entidades;
	}
	
	public function _getCampos($rs,$prefijo)
	{
		$campos = array_filter(
			array_keys($rs),
			function($key) use($prefijo){
				if((bool) preg_match("/^$prefijo/", $key)){
					return true;
				}
				return false;
			}
		);
		return array_reduce(
			$campos, 
			function($result,$campo) use($prefijo,$rs){
				$campoSinPrefijo = substr($campo, strlen($prefijo) +1,strlen($campo) - (strlen($prefijo)));
				$result[$campoSinPrefijo] = $rs[$campo];
				return $result;	
			},
		    array()
		);
	}
}