<?php

namespace Actividad\Actividad\Service\Participantes;

use EnterpriseSolutions\Db\Select as DbSelect;
use EnterpriseSolutions\Exceptions\Thrower;

class SelectParticipantes extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aap' => 'act_actividad_participantes'));
    }
    
    public function addSearchByActividad($id)
    {
        if (!$id) {
            Thrower::throwValidationException('Error de Validacion', 'No se encuentra la actividad');
        }
        
        $this->_select
             ->where("aap.act_actividad_id = $id");
    }
}