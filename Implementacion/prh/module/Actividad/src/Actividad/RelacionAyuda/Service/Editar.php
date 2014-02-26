<?php

namespace Actividad\RelacionAyuda\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Formador;
use Actividad\Actividad\Service\Formadores\Repository as FormadoresRepository;
use Actividad\Actividad\Service\Participantes\Repository as ParticipantesRepository;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;
use EnterpriseSolutions\Simple\Repository\DataSource;
use Actividad\Actividad\Participante;

class Editar
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
    
    protected $dbAdapter;
    
    public function __construct($em, $dbAdapter = null)
    {
        $this->em = $em;
        $this->actividad = null;
        $this->dbAdapter = $dbAdapter;
    }
    
    public function ejecutar($data)
    {
        $this->editarActividad($data['Actividad']);
        $this->em->persist($this->actividad);
        $this->asociarFormadores($data['Formadores']);
        $this->asociarParticipantes($data['Participantes']);
        $this->em->persist($this->actividad);
    }
    
    protected function editarActividad($data)
    {
        $act_actividad_id = $data['act_actividad_id'];
        $this->actividad = $this->em->find('Actividad\Actividad\Actividad', $act_actividad_id);
        
        if ($this->actividad == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe la actividad solicitada");
        }
        
        $this->actividad->fromArray($data);
    }
    
    protected function asociarFormadores($formadores)
    {
        $ds = new DataSource($this->dbAdapter);
        $formadoresRepository = new FormadoresRepository($ds);
        $formadoresAsociados = $formadoresRepository->find($this->actividad->getId());
        
        for ($i=0; $i<count($formadoresAsociados); $i++) {
            $found = false;
            for ($j=0; $j<count($formadores); $j++) {
                if ($formadoresAsociados[$i]['org_parte_rol_id'] == $formadores[$j]['org_parte_rol_id']) {
                    $found = true;
                }
            }
            
            if (!$found) {
                $formador = $this->em->find('Actividad\Actividad\Formador', $formadoresAsociados[$i]['act_actividad_formadores_id']);
                $this->em->remove($formador);
            }
        }
        
        for ($i=0; $i<count($formadores); $i++) {
            if ($formadores[$i]['act_actividad_formadores_id'] == 'new_id') {
                $esFormadorPrincipal = $formadores[$i]['es_principal'] == 'S' ? true : false;
                
                $formador = new Formador();
                $formador->setActividad($this->actividad);
                $formador->setFormador($this->getFormador($formadores[$i]), $esFormadorPrincipal);
                $this->em->persist($formador);
            }
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
    
    protected function asociarParticipantes($participantes)
    {
        $ds = new DataSource($this->dbAdapter);
        $participantesRepository = new ParticipantesRepository($ds);
        $participantesAsociados  = $participantesRepository->find($this->actividad->getId());
        
        for ($i=0; $i<count($participantesAsociados); $i++) {
            $found = false;
            for ($j=0; $j<count($participantes); $j++) {
                if ($participantesAsociados[$i]['org_parte_rol_id'] == $participantes[$j]['org_parte_rol_id']) {
                	$found = true;
                	$participante = $this->getParticipante($participantesAsociados[$i]);
                	$participante->setParticipanteRA($participantes[$j]);
                	$this->em->persist($participante);
                }
            }
            
            if (!$found) {
                $participante = $this->em->find('Actividad\Actividad\Participante', $participantesAsociados[$i]['act_actividad_participantes_id']);
                $this->em->remove($participante);
            }
        }
        
        for ($i=0; $i<count($participantes); $i++) {
            if ($participantes[$i]['act_actividad_participantes_id'] == 'new_id') {
                $participante = new Participante();
                $participante->setActividad($this->actividad);
                $participante->setParticipanteRA($participantes[$i]);
                $this->em->persist($participante);
            }
        }
    }
    
    protected function getParticipante($data)
    {
    	if (!isset($data['act_actividad_participantes_id'])) {
    		Thrower::throwValidationException('Error de Validacion', array('No se recibio el dato del participante'));
    	}
    
    	$participante = $this->em->find('Actividad\Actividad\Participante', $data['act_actividad_participantes_id']);
    	return $participante;
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}