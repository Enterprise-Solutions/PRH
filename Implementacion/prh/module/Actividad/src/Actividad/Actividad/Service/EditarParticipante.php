<?php

namespace Actividad\Actividad\Service;

use Actividad\Actividad\Participante;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class EditarParticipante
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    protected $participante;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $this->editar($data);
    }
    
    protected function editar($data)
    {
        $this->participante = $this->getParticipante($data);
        
        // Editar los datos del participante
        $this->participante->setMonto($data['monto_participante']);
        $this->participante->setImprimirCertificado($data['se_imprimio_certificado']);
        $this->participante->setEntregarCertificado($data['se_entrego_certificado']);
        $this->participante->setFechaEntregaCertificado($data['fecha_entrega_certificado']);
        
        $this->em->persist($this->participante);
    }
    
    /**
     * Obtiene un participante
     * @param array $data
     * @return Participante
     */
    protected function getParticipante($data)
    {
        if (!isset($data['act_actividad_participantes_id'])) {
            Thrower::throwValidationException('Error de Validacion', array('Participante no especificado'));
        }
        
        $participante = $this->em->find('Actividad\Actividad\Participante', $data['act_actividad_participantes_id']);
        return $participante;
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_participantes_id' => $this->participante->getId(),
            'exitoso' => true,
        );
    }
}