<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;
use Actividad\Actividad\Actividad;
use EnterpriseSolutions\Exceptions\Thrower;

class Editar
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
        $this->actividad = null;
    }
    
    public function ejecutar($data)
    {
        $this->editarActividad($data);
        $this->em->persist($this->actividad);
    }
    
    protected function editarActividad($data)
    {
        $act_actividad_id = $data['act_actividad_id'];
        $this->actividad = $this->em->find('Actividad\Actividad\Actividad', $act_actividad_id);
        
        if ($this->actividad == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe la actividad solicitada");
        }
        
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