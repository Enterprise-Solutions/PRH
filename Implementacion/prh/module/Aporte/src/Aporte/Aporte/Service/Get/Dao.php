<?php

namespace Aporte\Aporte\Service\Get;

use EnterpriseSolutions\Db\Dao\Get as GetDao;

class Dao extends GetDao
{
	public function _consultarDs()
	{
		$record = current($this->_select->execute()->toArray());
		
		if(!$record['roles']){
			$roles = array();
		}else{
			$roles = explode(';*', $record['roles']);
		}

		$roles = array_map(
				function($documentoString){
					$keyValueTokens = explode(",!",$documentoString);
					$documento = array();
					foreach($keyValueTokens as $token){
						//$tokens = explode(':', $keyValueToken);
						list($key,$value) = explode(':', $token);
						//$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
						$documento[$key] = (in_array($key, array('org_parte_rol_id')))?(integer)$value:$value;
					}
					return $documento;
				},
				$roles);
		$record['roles'] = $roles;
		return $record;
		
	} 
}