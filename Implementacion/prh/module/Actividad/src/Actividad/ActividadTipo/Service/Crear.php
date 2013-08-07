<?php

namespace Actividad\ActividadTipo\Service;

use Doctrine\ORM\EntityManager;
use Actividad\ActividadTipo\ActividadTipo;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Tipo de Actividad
     * @var ActividadTipo
     */
    protected $actividadTipo;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $this->crearActividadTipo($data);
        $this->em->persist($this->actividadTipo);
    }
    
    public function crearActividadTipo($data)
    {
        $this->actividadTipo = new ActividadTipo();
        $this->actividadTipo->fromArray($data);
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_tipo_id' => $this->actividadTipo->getId(),
            'exitoso'               => true,
        );
    }
}