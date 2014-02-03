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
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $identificador_participante;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $sobrenombre;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=250)
     */
    protected $descripcion;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=250)
     */
    protected $otra_info;
    
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
        foreach ($data as $participante) {
            $this->act_actividad_participantes_id = $participante['act_actividad_participantes_id'] == 'new_id' ? null : $participante['act_actividad_participantes_id'];
            $this->cont_moneda_id = $participante['cont_moneda_id'];
            $this->identificador_participante = $participante['identificador_participante'];
            $this->sobrenombre = $participante['sobrenombre'];
            $this->descripcion = $participante['descripcion'];
            $this->otra_info = $participante['otra_info'];
            $this->monto_participante = $participante['monto_participante'];
            $this->se_imprimio_certificado = $participante['se_imprimio_certificado'];
            $this->se_entrego_certificado = $participante['se_entrego_certificado'];
            $this->fecha_entrega_certificado = $participante['fecha_entrega_certificado'];
        }
    }
}