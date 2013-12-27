<?php

namespace Actividad\ActividadTipo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aat' => 'act_actividad_tipo'));
    }
    
    public function addSearchByNombre($nombre)
    {
        if ($nombre && $nombre != "") {
            $this->_select
                 ->where("aat.titulo ILIKE '%$nombre%'");
        }
    }
    
    public function addSearchByModalidad($modalidad)
    {
        if ($modalidad && $modalidad != "") {
            $this->_select
                 ->where("aat.modalidad = '$modalidad'");
        }
    }
}