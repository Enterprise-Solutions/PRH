<?php
namespace Actividad\Actividad\Service\AgregarParticipante;
use EnterpriseSolutions\Db\Select as EsSelect;

class SelectParticipanteDeActividad extends EsSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('aap' => 'act_actividad_participantes'))
             ->join(array('opr' => 'org_parte_rol'),'aap.org_parte_rol_id = opr.org_parte_rol_id',array());
    }
    
    public function addSearchByOrgParteId($orgParteId)
    {
        $this->_select
             ->where("opr.org_parte_id = $orgParteId");
    }
    
    public function addSearchByOrgRolCodigo($orgRolCodigo)
    {
        $this->_select
             ->where("opr.org_rol_codigo = '$orgRolCodigo'");
    }
    
    public function addSearchByActActividadId($actActividadId)
    {
        $this->_select
             ->where("aap.act_actividad_id = $actActividadId");
    }
}