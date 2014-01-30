<?php

namespace Actividad\Actividad\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Formador;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class Crear
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
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $this->crearActividad($data['Actividad']);
        $this->em->persist($this->actividad);
        $this->asociarFormadores($data['Formadores']);
        $this->em->persist($this->actividad);
    }
    
    protected function crearActividad($data)
    {
        $this->actividad = new Actividad();
        $data['requiere_certificado'] = $data['requiere_certificado'] == 'S' ? true : false;
        $this->actividad->fromArray($data);
    }
    
    protected function asociarFormadores($data)
    {
    	for ($i=0; $i<count($data); $i++) {
    	    $esFormadorPrincipal = $data[$i]['es_principal'] == 'S' ? true : false;
    	    
    		$formadorDeActividad = new Formador();
    		$formadorDeActividad->setActividad($this->actividad);
    		$formadorDeActividad->setFormador($this->getFormador($data[$i]), $esFormadorPrincipal);
    		
    		$this->em->persist($formadorDeActividad);
    	}
    }
    
    protected function getFormador($data)
    {
    	if (!isset($data['org_parte_rol_id'])) {
    		Thrower::throwValidationException('Error de Validacion', array('No se recibio el dato del formador'));
    	}
    	
    	$formador = $this->em->find('Org\Rol\RolDeParte', $data['org_parte_rol_id']);
    	return $formador;
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}