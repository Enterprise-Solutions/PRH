<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class DesasociarParticipante
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
        if (!isset($data['participante'])) {
            Thrower::throwValidationException('Error de Validacion', array('No se especifico el participante'));
        }
        
        $participanteAsignado = $this->em->find('Actividad\Actividad\Participante', $data['participante']);
        $this->desasociar($participanteAsignado);
    }
    
    protected function desasociar($participante)
    {
        $this->em->remove($participante);
    }
    
    public function getRespuesta()
    {
        return array(
            'exitoso' => true,
        );
    }
}