<?php
namespace Actividad\Actividad\Service;
use Actividad\Actividad\Service\AgregarParticipante\Repository;
use Org\RolesDePersonas\GetOCrear\Service;
use EnterpriseSolutions\Simple\Cambios\Cambios;



class AgregarParticipante
{
    public function ejecutar(Repository $repository,$params)
    {
        return ejecutar($repository, $params);
    }
}

/**
 * @param Repository $repository
 * @param array $params
 * 
 * 
 */
function ejecutar(Repository $repository,$params){
    $orgParteId        = $params['org_parte_id'];
    $actActividadId    = $params['act_actividad_id'];
    $montoParticipante = $params['monto_participante'];
    $contMonedaId      = $params['cont_moneda_id'];
    
    $actActividadParticipantesId = $repository->findParticipanteDeActividad($orgParteId, $actActividadId);
    if($actActividadParticipantesId){
        return _crearRespuesta(array(
            'act_actividad_participantes_id' => $actActividadParticipantesId,
            'act_actividad_id' => $actActividadId,
            'mensaje' => 'Ya esta como participante')
        );
    }
    
    $orgParteRolId = _crearORecuperarParticipante($repository, $params);
    $actActividadParticipantesId = _agregarActActividadParticipante(
        $repository, $orgParteRolId, $actActividadId,
        $montoParticipante, $contMonedaId
    );
    return _crearRespuesta(array(
        'act_actividad_participantes_id' => $actActividadParticipantesId,
        'act_actividad_id' => $actActividadId,
        'mensaje' => 'Se agrego el participante')
    );
    
}

function _crearORecuperarParticipante($repository,$params){
    $params['org_rol_codigo'] = 'participante';
    $service = new Service();
    $orgParteRolId = $service->ejecutar($repository, $params);
    //$orgParteRolId = crearORecuperarRol\ejecutar($repository, $params);
    return $orgParteRolId;
}

/**
 * @param Repository $repository
 * @param int $orgParteRolId
 * @param int $actActividadId
 */
function _agregarActActividadParticipante($repository,$orgParteRolId,$actActividadId,$montoParticipante, $contMonedaId){
    $cambiosActActividadParticipante = array(
    	array('org_parte_rol_id'   => $orgParteRolId),
        array('act_actividad_id'   => $actActividadId),
        array('monto_participante' => $montoParticipante),
        array('cont_moneda_id'     => $contMonedaId),
        array('se_imprimio_certificado'   => 'N'),
        array('se_entrego_certificado'    => 'N')
    );
    $cambiosUtil = new Cambios();
    $cambiosActActividadParticipante = $cambiosUtil->cambiar(array(), $cambiosActActividadParticipante);
    $cambiosRealizados = $repository->persistirCambiosADatos(
        $cambiosActActividadParticipante, 
        array(), 
        'act_actividad_participantes', 
        'act_actividad_participantes_id'
    );
    return $cambiosUtil->getValorNuevo($cambiosRealizados, 'act_actividad_participantes_id');
}

function _crearRespuesta($params){
    return array(
        'exitoso' => true,
        'mensaje' => $params['mensaje'],
        'datos' => array('act_actividad_participantes_id' => $params['act_actividad_participantes_id'],'act_actividad_id' => $params['act_actividad_id'])
    );
}