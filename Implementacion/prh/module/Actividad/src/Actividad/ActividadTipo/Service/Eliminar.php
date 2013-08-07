<?php

namespace Actividad\ActividadTipo\Service;

use Doctrine\ORM\EntityManager;
use Actividad\ActividadTipo\ActividadTipo;
use EnterpriseSolutions\Exceptions\Thrower;

class Eliminar
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
    
    /**
     * Id eliminado
     * @var integer
     */
    protected $actividadTipoId;
    
    public function __construct($em)
    {
        $this->em = $em;
        $this->actividadTipo = null;
    }
    
    public function ejecutar($data)
    {
        $this->eliminarActividadTipo($data);
        $this->em->remove($this->actividadTipo);
    }
    
    public function eliminarActividadTipo($data)
    {
        $act_actividad_tipo_id = $data['act_actividad_tipo_id'];
        $this->actividadTipo = $this->em->find('Actividad\ActividadTipo\ActividadTipo', $act_actividad_tipo_id);
    
        if ($this->actividadTipo == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe el tipo de actividad solicitado");
        }
        
        $actividades = $this->em->getRepository('Actividad\Actividad\Actividad')->findBy(array('act_actividad_tipo_id' => $act_actividad_tipo_id));
        if (count($actividades)) {
        	Thrower::throwValidationException('Error de Validacion', "Existen actividades que utilizan este tipo");
        }
        
        $this->actividadTipoId = $act_actividad_tipo_id;
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_tipo_id' => $this->actividadTipoId,
            'exitoso'               => true,
        );
    }
}