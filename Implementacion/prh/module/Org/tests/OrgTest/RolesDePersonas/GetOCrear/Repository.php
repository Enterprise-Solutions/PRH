<?php
namespace Org\RolesDePersonas\GetOCrear;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;
use Org\RolesDePersonas\GetOCrear\Repository\SelectOrgParteConRol;
class Repository extends EsRepository
{    
    public function findOrgParteRol($orgParteId,$orgRolCodigo)
    {
        $select = new SelectOrgParteConRol($this->_ds->_getDbConnection());
        $select->addSearchByOrgParteId($orgParteId);
        $select->addSearchByOrgRolCodigo($orgRolCodigo);
        $rs = $select->execute()->toArray();
        if(count($rs) == 0){
            return false;
        }
        return $rs[0]['org_parte_rol_id'];
    }
}
