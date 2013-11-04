<?php

namespace Actividad\Actividad\Service;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class DesasociarFormador
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
        if (!isset($data['formador'])) {
            Thrower::throwValidationException('Error de Validacion', array('No se especifico el formador'));
        }
        
        $formadorAsignado = $this->em->find('Actividad\Actividad\Formador', $data['formador']);
        $this->desasociar($formadorAsignado);
    }
    
    protected function desasociar($formador)
    {
        $this->em->remove($formador);
    }
    
    public function getRespuesta()
    {
        return array(
            'exitoso' => true,
        );
    }
}