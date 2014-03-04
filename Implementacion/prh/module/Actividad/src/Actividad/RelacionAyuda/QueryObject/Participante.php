<?php

namespace Actividad\RelacionAyuda\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Participante extends DbSelect
{
    protected $prefijoIdentificador = 'SIN-PREFIJO';
    
    public function _init()
    {
        $this->_select
             ->from(array('apa' => 'act_participante_anonimo'));
    }
    
    public function setPrefijoIdentificador($prefijoIdentificador)
    {
        $this->prefijoIdentificador = $prefijoIdentificador;
        $this->_select
             ->where("apa.identificador ILIKE '{$this->prefijoIdentificador}-%'");
    }
    
    public function addSearchByIdentificador($identificador)
    {
        $identificador = implode('-', array($this->prefijoIdentificador, $identificador));
        $this->_select
             ->where("apa.identificador ILIKE '$identificador%'");
    }
}