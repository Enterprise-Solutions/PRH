<?php

namespace Actividad\RelacionAyuda\Service;

use Actividad\Actividad\Actividad;
use Actividad\Actividad\Participante;
use Actividad\Actividad\Participante\Anonimo as ParticipanteAnonimo;
use Actividad\Actividad\Formador;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;
use EnterpriseSolutions\Simple\Repository\DataSource;
use Application\Authentication\Identidad;

class Editar
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
    
    public function __construct($em, $dbAdapter = null)
    {
        $this->em = $em;
    }
    
    public function setLoggedUser($loggedUser)
    {
    	$this->loggedUser = $loggedUser;
    }
    
    public function ejecutar($data)
    {
        $this->editarRelacionAyuda($data['Actividad']);
        //$this->asociarParticipantes($data['Participantes']);
        //$this->asociarFormador();
    }
    
    protected function editarRelacionAyuda($data)
    {
        $act_actividad_id = $data['act_actividad_id'];
        $this->actividad->fromArray($data);
        $this->em->persist($this->actividad);
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