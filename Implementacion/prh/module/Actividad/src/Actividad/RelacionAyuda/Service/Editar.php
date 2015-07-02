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

    protected $dbAdapter;
    
    public function __construct($em, $dbAdapter = null)
    {
        $this->em = $em;
        $this->actividad = null;
        $this->dbAdapter = $dbAdapter;
    }
    
    
    public function setLoggedUser($loggedUser)
    {
    	$this->loggedUser = $loggedUser;
    }
    
    public function ejecutar($data)
    {
        $this->editarRelacionAyuda($data['Actividad']);
        $this->em->persist($this->actividad);
        $this->asociarParticipantes($data['Participantes']);
        //$this->asociarFormador();
    }
    
    protected function editarRelacionAyuda($data)
    {
        /*$this->editarActividad($data['Actividad']);
        $this->em->persist($this->actividad);
        $this->asociarFormadores($data['Formadores']);*/

        $act_actividad_id = $data['act_actividad_id'];
        $this->actividad = $this->em->find('Actividad\Actividad\Actividad', $act_actividad_id);
        
        if ($this->actividad == null) {
            Thrower::throwValidationException('Error de Validacion', "No existe la actividad solicitada");
        }
        
        $this->actividad->fromArray($data);
       // $this->actividad->fromArray($data);
        
    }

    protected function asociarParticipantes($data)
    {
    	for ($i=0; $i<count($data); $i++) {
    		if (!$this->tieneIdentificador($data[$i])) {
    			Thrower::throwValidationException('Error de Validacion', array('El identificador del participante es obligatorio'));
    		}
    
    		$this->actualizarParticipanteAnonimo($data[$i]);
    
            
    		$this->participanteDeActividad = $this->em->find('Actividad\Actividad\Participante', $data[$i]['act_actividad_participantes_id']);

    		$this->participanteDeActividad->setActividad($this->actividad);
    		$this->participanteDeActividad->setParticipanteAnonimo($this->participanteAnonimo);
    		$this->participanteDeActividad->setMoneda($data[$i]['cont_moneda_id']);
    		$this->participanteDeActividad->setMonto($data[$i]['monto_participante']);
    		$this->participanteDeActividad->setDefaultValues();
    
    		$this->em->persist($this->participanteDeActividad);
    	}
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
        // if ($data['act_participante_anonimo_id'] == 'new_id') {
        //     $this->participanteAnonimo = new ParticipanteAnonimo();
        //     $identificador = $this->prefijoIdentificador . $data['identificador'];
        // } else {
            $this->participanteAnonimo = $this->em->find('Actividad\Actividad\Participante\Anonimo', $data['act_participante_anonimo_id']);
            $identificador = $data['identificador'];
        //}
        
        $this->participanteAnonimo->setIdentificador($identificador);
        $this->participanteAnonimo->setAlias($data['alias']);
        $this->participanteAnonimo->setDescripcion($data['descripcion']);
        
        $this->em->persist($this->participanteAnonimo);
    }
    
    public function getRespuesta()
    {
        return array(
            'act_actividad_id' => $this->actividad->getId(),
            'exitoso'          => true,
        );
    }
}