<?php

namespace Actividad\Actividad;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participante de una Actividad
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="act_actividad_participantes")
 */
class Participante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $act_actividad_participantes_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad\Actividad\Actividad")
     * @ORM\JoinColumn(name="act_actividad_id", referencedColumnName="act_actividad_id")
     */
    protected $actividad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Org\Rol\RolDeParte")
     * @ORM\JoinColumn(name="org_parte_rol_id", referencedColumnName="org_parte_rol_id")
     */
    protected $participante;
    
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }
    
    public function setParticipante($participante)
    {
        $this->participante = $participante;
    }
}