<?php

namespace Actividad\ActividadTipo\Service;

use Doctrine\ORM\EntityManager;
use Actividad\ActividadTipo\ActividadTipo;
use EnterpriseSolutions\Exceptions\Thrower;

class Editar
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
        $this->actividadTipo = null;
    }
    
    public function ejecutar($data)
    {
        $this->editarActividadTipo($data);
        $this->em->persist($this->actividadTipo);
    }
    
    public function editarActividadTipo($data)
    {
        $act_actividad_tipo_id = $data['act_actividad_tipo_id'];
        $this->actividadTipo = $this->em->find('Actividad\ActividadTipo\ActividadTipo', $act_actividad_tipo_id);
        
        if ($this->actividadTipo == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe el tipo de actividad solicitado");
        }
        
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