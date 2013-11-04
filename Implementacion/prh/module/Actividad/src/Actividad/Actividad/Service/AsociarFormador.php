<?php

namespace Actividad\Actividad\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Formador;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class AsociarFormador
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
        $formador  = $this->getFormador($data);
        $this->asignarFormador($actividad, $formador);
    }
    
    protected function asignarFormador($actividad, $formador)
    {
        $formadorDeActividad = new Formador();
        $formadorDeActividad->setActividad($actividad);
        $formadorDeActividad->setFormador($formador);
        
        $this->em->persist($formadorDeActividad);
    }
    
    protected function getActividad($data)
    {
        if (!isset($data['act_actividad_id'])) {
            Thrower::throwValidationException('Actividad no especificada');
        }
        
        $actividad = $this->em->find('Actividad\Actividad\Actividad', $data['act_actividad_id']);
        return $actividad;
    }
    
    protected function getFormador($data)
    {
        if (!isset($data['org_parte_rol_id'])) {
            Thrower::throwValidationException('No se recibio el dato del formador');
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