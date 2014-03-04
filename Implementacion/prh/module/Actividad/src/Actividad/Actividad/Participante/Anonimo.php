<?php

namespace Actividad\Actividad\Participante;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participante de las actividades de Relacion de Ayuda
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="act_participante_anonimo")
 */
class Anonimo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $act_participante_anonimo_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $identificador;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $alias;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=250)
     */
    protected $descripcion;
    
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
    }
    
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}