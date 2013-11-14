<?php
namespace Actividad\Actividad\Service\AgregarParticipante;
use Org\RolesDePersonas\GetOCrear\Repository as OrgParteRolRepository;
use Actividad\Actividad\Service\AgregarParticipante\SelectParticipanteDeActividad;
class Repository extends OrgParteRolRepository
{
    public function findParticipanteDeActividad($orgParteId,$actActividadId)
    {
        $select = new SelectParticipanteDeActividad($this->_ds->_getDbConnection());
        $select->addSearchByOrgParteId($orgParteId);
        $select->addSearchByOrgRolCodigo('participante');
        $select->addSearchByActActividadId($actActividadId);
        $rs = $select->execute()->toArray();
        if(count($rs) > 0){
            return $rs[0]['act_actividad_participantes_id'];
        }
        return false;
    }
}