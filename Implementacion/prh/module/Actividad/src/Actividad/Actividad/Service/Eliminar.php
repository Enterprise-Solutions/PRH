<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;
use Actividad\Actividad\Actividad;
use EnterpriseSolutions\Exceptions\Thrower;

class Eliminar
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
    
    /**
     * Id eliminado
     * @var integer
     */
    protected $actividadId;
    
    public function __construct($em)
    {
        $this->em = $em;
        $this->actividad = null;
    }
    
    public function ejecutar($data)
    {
        $this->eliminarActividad($data);
        $this->em->remove($this->actividad);
    }
    
    public function eliminarActividad($data)
    {
        $act_actividad_id = $data['act_actividad_id'];
        $this->actividad = $this->em->find('Actividad\Actividad\Actividad', $act_actividad_id);
    
        if ($this->actividad == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe la actividad solicitada");
        }
        
        /**
         * @todo Agregar control de Movimiento de Actividades
         * @todo Agregar control de Formadores de Actividad
         * @todo Agregar control de Participantes de Actividad
         */
        
        $this->actividadId = $act_actividad_id;
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividadId,
            'exitoso'          => true,
        );
    }
}