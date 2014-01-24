<?php

namespace Actividad\Actividad;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formador asignado a una Actividad
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="act_actividad_formadores")
 */
class Formador
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $act_actividad_formadores_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad\Actividad\Actividad")
     * @ORM\JoinColumn(name="act_actividad_id", referencedColumnName="act_actividad_id")
     */
    protected $actividad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Org\Rol\RolDeParte")
     * @ORM\JoinColumn(name="org_parte_rol_id", referencedColumnName="org_parte_rol_id")
     */
    protected $formador;
    
    /**
     * @Orm\Column(type="boolean")
     */
    protected $es_principal;
    
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }
    
    public function setFormador($formador, $es_principal)
    {
        $this->formador = $formador;
        $this->es_principal = $es_principal;
    }
}