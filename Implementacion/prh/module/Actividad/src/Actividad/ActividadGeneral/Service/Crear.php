<?php

namespace Actividad\ActividadGeneral\Service;

use Actividad\ActividadGeneral\ActividadGeneral as Actividad;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

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
        $this->crearActividad($data['Actividad']);
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
            'act_actividad_general_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}