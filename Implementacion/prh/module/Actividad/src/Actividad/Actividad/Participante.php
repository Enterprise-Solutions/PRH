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
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $act_actividad_formadores_id;
    
    /**
     * @Orm\Column(type="float")
     */
    protected $monto_participante;
    
    /**
     * @Orm\Column(type="boolean")
     */
    protected $se_imprimio_certificado;
    
    /**
     * @Orm\Column(type="boolean")
     */
    protected $se_entrego_certificado;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $fecha_entrega_certificado;
    
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }
    
    public function setParticipante($participante)
    {
        $this->participante = $participante;
    }
    
    public function setParticipanteRA($data)
    {
        foreach ($data as $campo => $valor) {
            $this->$campo = $valor;
        }
    }
}