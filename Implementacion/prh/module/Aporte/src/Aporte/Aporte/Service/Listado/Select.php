<?php

namespace Aporte\Aporte\Service\Listado;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
             ->from(array('op' => 'org_parte'))
             ->columns(array('org_parte_id', 
                             'persona'   => new Expression("op.nombre_persona||' '||op.apellido_persona"),
                             'documento' => new Expression("od.valor||'/'||od.org_documento_tipo_codigo")))
             ->join(
             	array('od' => 'org_documento'), 
             	'od.org_parte_id = op.org_parte_id',
             	array())
             ->where('od.preferencia = 1');
            
	}

    public function addSearchByDocumento ($documento)
    {
        $this->_select
             ->where("od.valor ~* '$documento'");        
    }

    public function addSearchByNombre ($nombre)
    { 
        $this->_select
             ->where(" ( ('('||op.nombre_persona || '|' || op.apellido_persona||')') ~* '$nombre') ");        
    }

    public function addSearchById ($parteId)
    {
        if ($id) {
            $this->_select
                 ->where("op.org_parte_id = $parteId");
        }
    }
}