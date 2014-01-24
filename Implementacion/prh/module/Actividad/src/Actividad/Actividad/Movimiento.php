<?php

namespace Actividad\Actividad;

use Doctrine\ORM\Mapping as Orm;

/**
 * Movimiento de una actividad
 * @author guido
 * 
 * @Orm\Entity
 * @Orm\Table(name="act_actividad_movimiento")
 */
class Movimiento
{
    /**
     * @Orm\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $act_actividad_movimiento_id;
    
    /**
     * @Orm\ManyToOne(targetEntity="Actividad\Actividad\Actividad")
     * @Orm\JoinColumn(name="act_actividad_id", referencedColumnName="act_actividad_id")
     */
    protected $actividad;
}