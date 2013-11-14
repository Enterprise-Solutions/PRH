<?php
namespace Actividad\Actividad\Service\AgregarParticipante;
require_once 'Implementacion/prh/module/Org/src/Org/RolesDePersonas/GetOCrear/Service.php';
use Actividad\Actividad\Service\AgregarParticipante\Repository;
use Org\RolesDePersonas\GetOCrear\Service as crearORecuperarRol;
use EnterpriseSolutions\Simple\Cambios\Cambios;

/**
 * @param Repository $repository
 * @param array $params
 * 
 * 
 */
function ejecutar(Repository $repository,$params){
    $orgParteId = $params['org_parte_id'];
    $actActividadId = $params['act_actividad_id'];
    $actActividadParticipantesId = $repository->findParticipanteDeActividad($orgParteId, $actActividadId);
    if($actActividadParticipantesId){
        return _crearRespuesta(array(
            'act_actividad_participantes_id' => $actActividadParticipantesId,
            'act_actividad_id' => $actActividadId,
            'mensaje' => 'Ya esta como participante')
        );
    }
    $orgParteRolId = _crearORecuperarParticipante($repository, $params);
    $actActividadParticipantesId = _agregarActActividadParticipante($repository, $orgParteRolId, $actActividadId);
    return _crearRespuesta(array(
        'act_actividad_participantes_id' => $actActividadParticipantesId,
        'act_actividad_id' => $actActividadId,
        'mensaje' => 'Se agrego el participante')
    );
    
}

function _crearORecuperarParticipante($repository,$params){
    $params['org_rol_codigo'] = 'participante';
    $orgParteRolId = crearORecuperarRol\ejecutar($repository, $params);
    return $orgParteRolId;
}

/**
 * @param Repository $repository
 * @param int $orgParteRolId
 * @param int $actActividadId
 */
function _agregarActActividadParticipante($repository,$orgParteRolId,$actActividadId){
    $cambiosActActividadParticipante = array(
    	array('org_parte_rol_id' => $orgParteRolId),
        array('act_actividad_id' => $actActividadId)
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