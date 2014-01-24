<?php

namespace Actividad\Actividad;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as Orm;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;

/**
 * @author mimt
 * @Orm\Entity
 * @Orm\Table(name="act_actividad")
 */
class Actividad
{
    /**
     * @Orm\Id
     * @Orm\GeneratedValue(strategy="AUTO")
     * @Orm\Column(type="integer")
     */
    protected $act_actividad_id;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $act_actividad_tipo_id;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $cal_anho_formacion_id;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $act_ciclo_id;
    
    /**
     * @Orm\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $titulo;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $fecha_inicio;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $fecha_fin;
    
    /**
     * @Orm\Column(type="float")
     */
    protected $duracion;
    
    /**
     * @Orm\Column(type="float")
     */
    protected $monto_referencial;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $nro_personas;
    
    /**
     * @Orm\Column(type="boolean")
     */
    protected $requiere_certificado;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $observaciones;
    
    /**
     * @Orm\Column(type="string")
     * @Orm\Column(length=1)
     */
    protected $atelier;
    
    /**
     * @Orm\Column(type="string")
     * @Orm\Column(length=1)
     */
    protected $asistencia;
    
    /**
     * @Orm\Column(type="string")
     * @Orm\Column(length=1)
     */
    protected $modalidad_act;
    
    /**
     * @Orm\Column(type="string")
     * @Orm\Column(length=80)
     */
    protected $codigo;
    
    /**
     * @Orm\OneToMany(targetEntity="Actividad\Actividad\Formador", mappedBy="actividad")
     */
    protected $formadores;
    
    /**
     * @Orm\OneToMany(targetEntity="Actividad\Actividad\Participante", mappedBy="actividad")
     */
    protected $participantes;
    
    /**
     * @Orm\OneToMany(targetEntity="Actividad\Actividad\Movimiento", mappedBy="actividad")
     */
    protected $movimientos;
    
    /**
     * @Orm\OneToMany(targetEntity="Actividad\Actividad\Evento", mappedBy="actividad")
     */
    protected $eventos;
    
    public function getFormadores()
    {
        return $this->formadores;
    }
    
    public function getParticipantes()
    {
        return $this->participantes;
    }
    
    public function getMovimientos()
    {
        return $this->movimientos;
    }
    
    public function getEventos()
    {
        return $this->eventos;
    }
    
    public function __construct()
    {
        $this->formadores    = new ArrayCollection();
        $this->participantes = new ArrayCollection();
        $this->movimientos   = new ArrayCollection();
        $this->eventos       = new ArrayCollection();
    }

    /**
     * Input Filter
     * @param array $data
     * @return Ambigous <\Zend\InputFilter\InputFilterInterface, \Zend\InputFilter\CollectionInputFilter, unknown, object>
     */
    protected function getInputFilter($data)
    {
        $inputFilterFactory = new InputFilterFactory();
        $spec = array(
            'act_actividad_tipo_id' => array(
                'name'     => 'act_actividad_tipo_id',
                'required' => true,
            ),
            'cont_moneda_id' => array(
                'name'     => 'cont_moneda_id',
                'required' => true,
            ),
            'cal_anho_formacion_id' => array(
                'name'     => 'cal_anho_formacion_id',
                'required' => true,
            ),
            'act_ciclo_id' => array(
                'name'     => 'act_ciclo_id',
                'required' => true,
            ),
            'titulo' => array(
                'name'     => 'titulo',
                'required' => false,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'Alpha'),
                ),
                'validator' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 100, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'fecha_inicio' => array(
                'name'      => 'fecha_inicio',
                'required'  => false,
                'validator' => array(
                    array('name'=>'Date','options'=>array('format'=>'yyyy-MM-dd','message'=>'No es una fecha valida. El formato tiene que ser anho-mes-dia'))
                )
            ),
            'fecha_fin' => array(
                'name'      => 'fecha_fin',
                'required'  => false,
                'validator' => array(
                    array('name'=>'Date','options'=>array('format'=>'yyyy-MM-dd','message'=>'No es una fecha valida. El formato tiene que ser anho-mes-dia'))
                )
            ),
            'duracion' => array(
                'name'       => 'duracion',
                'required'   => false,
            ),
            'monto_referencial' => array(
                'name'      => 'monto_referencial',
                'required'  => false,
            ),
            'nro_personas' => array(
                'name'      => 'nro_personas',
                'required'  => false,
                'validators' => array(
                    array('name' => 'Digits', 'options' => array('message' => 'Esta mal')),
                ),
            ),
            'requiere_certificado' => array(
                'name'      => 'requiere_certificado',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'observaciones' => array(
                'name'      => 'observaciones',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
            ),
            'atelier' => array(
                'name'      => 'atelier',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'asistencia' => array(
                'name'      => 'asistencia',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'modalidad_act' => array(
                'name'      => 'modalidad_act',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'codigo' => array(
                'name'      => 'codigo',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 80, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
        );
        
        $inputFilter = $inputFilterFactory->createInputFilter($spec);
        $inputFilter->setData($data);
        return $inputFilter;
    }
    
    /**
     * Carga los datos en el objeto
     * @param array $data
     */
    public function fromArray($data)
    {
        $inputFilter = $this->getInputFilter($data);
        if (!$inputFilter->isValid()) {
            $errorMessages = array();
            foreach ($inputFilter->getMessages() as $invalidInput => $errors) {
                $errorsType = array_keys($errors);
                foreach ($errorsType as $errorType) {
                    $errorMessages[$invalidInput] = $errors[$errorType];
                }
            }
            Thrower::throwValidationException('Error de Validacion', $errorMessages);
        }
        $data = $inputFilter->getValues();
    
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
    
    public function getId()
    {
        return $this->act_actividad_id;
    }
}