<?php

namespace Aporte\Aporte\Service\Get;

use EnterpriseSolutions\Db\Dao\Get as GetDao;

class DaoAportes extends GetDao
{
	public function _consultarDs()
	{
		$record = current($this->_select->execute()->toArray());

		if(!$record['detalles']){
			$detalles = array();
		}else{
			$detalles = explode(';*', $record['detalles']);
		}

		$detalles = array_map(
				function($documentoString){
					$keyValueTokens = explode(",!",$documentoString);
					$documento = array();
					foreach($keyValueTokens as $token){
						//$tokens = explode(':', $keyValueToken);
						list($key,$value) = explode(':', $token);
						//$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
						$documento[$key] = (in_array($key, array('ap_aporte_detalle_id')))?(integer)$value:$value;
					}
					return $documento;
				},
				$detalles);
		$record['detalles'] = $detalles;

		return $record;
		
	} 
}