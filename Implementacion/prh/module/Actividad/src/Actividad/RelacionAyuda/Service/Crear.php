<?php

namespace Actividad\RelacionAyuda\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Formador;
use Actividad\Actividad\Participante;
use Actividad\Actividad\Participante\Anonimo as ParticipanteAnonimo;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;
use Application\Authentication\Identidad;

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
    
    /**
     * Formador de la Actividad
     * @var Formador
     */
    protected $formadorDeActividad;
    
    /**
     * Participante de la Actividad
     * @var Participante
     */
    protected $participanteDeActividad;
    
    /**
     * Participante Anonimo
     * @var ParticipanteAnonimo
     */
    protected $participanteAnonimo;
    
    /**
     * Usuario logueado
     * @var Identidad
     */
    protected $loggedUser;
    
    /**
     * Prefijo del usuario logueado
     * @var string
     */
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
        $this->asociarParticipantes($data['Participantes']);
        $this->asociarFormador();
    }
    
    protected function crearRelacionAyuda($data)
    {
        $this->actividad = new Actividad();
        $this->actividad->fromArray($data);
        $this->em->persist($this->actividad);
    }
    
    protected function asociarFormador()
    {
        $this->formadorDeActividad = new Formador();
        $this->formadorDeActividad->setActividad($this->actividad);
        $this->formadorDeActividad->setFormador($this->getFormador(), 'S');
        $this->em->persist($this->formadorDeActividad);
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
        if ($data['act_participante_anonimo_id'] == 'new_id') {
            $this->participanteAnonimo = new ParticipanteAnonimo();
            $identificador = $this->prefijoIdentificador . $data['identificador'];
        } else {
            $this->participanteAnonimo = $this->em->find('Actividad\Actividad\Participante\Anonimo', $data['act_participante_anonimo_id']);
            $identificador = $data['identificador'];
        }
        
        $this->participanteAnonimo->setIdentificador($identificador);
        $this->participanteAnonimo->setAlias($data['alias']);
        $this->participanteAnonimo->setDescripcion($data['descripcion']);
        
        $this->em->persist($this->participanteAnonimo);
    }
    
    protected function asociarParticipantes($data)
    {
        for ($i=0; $i<count($data); $i++) {
            if (!$this->tieneIdentificador($data[$i])) {
                Thrower::throwValidationException('Error de Validacion', array('El identificador del participante es obligatorio'));
            }
            
            $this->actualizarParticipanteAnonimo($data[$i]);
            
            $this->participanteDeActividad = new Participante();
            $this->participanteDeActividad->setActividad($this->actividad);
            $this->participanteDeActividad->setParticipanteAnonimo($this->participanteAnonimo);
            $this->participanteDeActividad->setMoneda($data[$i]['cont_moneda_id']);
            $this->participanteDeActividad->setMonto($data[$i]['monto_participante']);
            $this->participanteDeActividad->setDefaultValues();
            
            $this->em->persist($this->participanteDeActividad);
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