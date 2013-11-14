<?php
namespace Org\RolesDePersonas\GetOCrear\Repository;
use EnterpriseSolutions\Db\Select as EsSelect;
use Zend\Db\Sql\Select as ZfSelect;

class SelectOrgParteConRol extends EsSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('op' => 'org_parte'))
             ->columns(array('org_parte_id'))
             ->join(array('opr' => 'org_parte_rol'),'op.org_parte_id = opr.org_parte_id',array('org_parte_rol_id'),ZfSelect::JOIN_LEFT)
             ->join(array('r' => 'org_rol'),'opr.org_rol_codigo = r.org_rol_codigo',array('org_rol_codigo'),ZfSelect::JOIN_LEFT);
    }
    
    public function addSearchByOrgRolCodigo($orgRolCodigo)
    {
        $this->_select
             ->where("opr.org_rol_codigo = '$orgRolCodigo'");
    }
    
    public function addSearchByOrgParteId($orgParteId)
    {
        $this->_select
             ->where("op.org_parte_id = $orgParteId");
    }
}