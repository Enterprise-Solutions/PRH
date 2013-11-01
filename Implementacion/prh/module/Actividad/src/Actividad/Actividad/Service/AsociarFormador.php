<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;

class AsociarFormador
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        
    }
    
    public function getRespuesta()
    {
        
    }
}