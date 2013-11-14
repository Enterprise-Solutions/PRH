<?php
namespace Org\RolesDePersonas\GetOCrear\Service;
use EnterpriseSolutions\Simple\Cambios\Cambios;
use Org\RolesDePersonas\GetOCrear\Repository;
/**
 * @param Repository $repository
 * @param array $params
 */
function ejecutar($repository,$params){
    $orgParteId = $params['org_parte_id'];
    $orgRolCodigo = $params['org_rol_codigo'];
    $orgParteRolId = $repository->findOrgParteRol($orgParteId,$orgRolCodigo);
    if(!$orgParteRolId){
        $cambios = new Cambios();
        $cambiosOrgParteRol = $cambios->cambiar(
            array(), 
            array(
        	   array('org_parte_id' => $orgParteId),
               array('org_rol_codigo' => $orgRolCodigo)
            )
        );
        $cambiosOrgParteRol = $repository->persistirCambiosADatos($cambiosOrgParteRol, array(), 'org_parte_rol','org_parte_rol_id');
        $orgParteRolId = $cambios->getValorNuevo($cambiosOrgParteRol, 'org_parte_rol_id');
    }
    return $orgParteRolId;
}