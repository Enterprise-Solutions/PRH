<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;
use Actividad\Actividad\Actividad;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Actividad
     * @var Actividad
     */
    protected $actividad;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $this->crearActividad($data);
        $this->em->persist($this->actividad);
    }
    
    protected function crearActividad($data)
    {
        $this->actividad = new Actividad();
        $this->actividad->fromArray($data);
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}