<?php

namespace Actividad\Actividad\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Participante;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class AsociarParticipante
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $actividad = $this->getActividad($data);
        $participante = $this->getParticipante($data);
        $this->asignarParticipante($actividad, $participante);
    }
    
    protected function asignarParticipante($actividad, $participante)
    {
        $participanteDeActividad = new Participante();
        $participanteDeActividad->setActividad($actividad);
        $participanteDeActividad->setParticipante($participante);
        
        $this->em->persist($participanteDeActividad);
    }
    
    protected function getActividad($data)
    {
        if (!isset($data['act_actividad_id'])) {
            Thrower::throwValidationException('Actividad no especificada');
        }
        
        $actividad = $this->em->find('Actividad\Actividad\Actividad', $data['act_actividad_id']);
        return $actividad;
    }
    
    protected function getParticipante($data)
    {
        if (!isset($data['org_parte_rol_id'])) {
            Thrower::throwValidationException('No se recibio el dato del participante');
        }
        
        $formador = $this->em->find('Org\Rol\RolDeParte', $data['org_parte_rol_id']);
        return $formador;
    }
    
    public function getRespuesta()
    {
        return array(
            'exitoso' => true,
        );
    }
}