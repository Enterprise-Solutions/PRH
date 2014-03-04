<?php

namespace Actividad\RelacionAyuda\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Formador;
use Actividad\Actividad\Participante;
use Actividad\Actividad\Participante\Anonimo as ParticipanteAnonimo;
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
     * Actividad Relacion de Ayuda
     * @var Actividad
     */
    protected $actividad;
    
    protected $loggedUser;
    protected $prefijoIdentificador;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function setLoggedUser($loggedUser)
    {
        $this->loggedUser = $loggedUser;
    }
    
    public function setPrefijoIdentificador($prefijo)
    {
        $this->prefijoIdentificador = $prefijo . '-';
    }
    
    public function ejecutar($data)
    {
        $this->crearRelacionAyuda($data['Actividad']);
        $this->em->persist($this->actividad);
        $this->asociarFormador();
        $this->em->persist($this->actividad);
        $this->asociarParticipantes($data['Participantes']);
        $this->em->persist($this->actividad);
    }
    
    protected function crearRelacionAyuda($data)
    {
        $this->actividad = new Actividad();
        $this->actividad->fromArray($data);
    }
    
    protected function asociarFormador()
    {
        $formadorDeActividad = new Formador();
        $formadorDeActividad->setActividad($this->actividad);
        $formadorDeActividad->setFormador($this->getFormador(), 'S');
    }
    
    protected function getFormador()
    {
        $formador = $this->em->getRepository('Org\Rol\RolDeParte')->findOneBy(array(
            'parte' => $this->loggedUser->org_parte_id,
            'rol'   => 'formador',
        ));
        
        if (!$formador) {
            Thrower::throwValidationException('Error de Validacion', array('El usuario logueado no es formador'));
        }
        
        return $formador;
    }
    
    protected function tieneIdentificador($data)
    {
        if (isset($data['identificador'])) {
            if (!$data['identificador']) {
                return false;
            }
            return true;
        }
        return false;
    }
    
    protected function actualizarParticipanteAnonimo($data)
    {
        if (!is_int($data['act_participante_anonimo_id'])) {
            $participanteAnonimo = new ParticipanteAnonimo();
        } else {
            $participanteAnonimo = $this->em->find('Actividad\Actividad\Participante\Anonimo', $data['act_participante_anonimo_id']);
        }
        
        $identificador = $this->prefijoIdentificador . $data['identificador']; 
        $participanteAnonimo->setIdentificador($identificador);
        $participanteAnonimo->setAlias($data['alias']);
        $participanteAnonimo->setDescripcion($data['descripcion']);
        
        $this->em->persist($participanteAnonimo);
        return $participanteAnonimo;
    }
    
    protected function asociarParticipantes($data)
    {
        for ($i=0; $i<count($data); $i++) {
            if (!$this->tieneIdentificador($data[$i])) {
                Thrower::throwValidationException('Error de Validacion', array('El identificador del participante es obligatorio'));
            }
            
            $participanteAnonimo = $this->actualizarParticipanteAnonimo($data[$i]);
            
            $participanteDeActividad = new Participante();
            $participanteDeActividad->setActividad($this->actividad);
            $participanteDeActividad->setParticipanteAnonimo($participanteAnonimo);
            $participanteDeActividad->setMoneda($data[$i]['cont_moneda_id']);
            $participanteDeActividad->setMonto($data[$i]['monto_participante']);
            $participanteDeActividad->setDefaultValues();
            $this->em->persist($participanteDeActividad);
        }
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}