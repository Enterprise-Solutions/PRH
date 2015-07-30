<?php

namespace Actividad\ActividadGeneral;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as Orm;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;

/**
 * @author mimt
 * @Orm\Entity
 * @Orm\Table(name="act_actividad_general")
 */
class ActividadGeneral
{
    /**
     * @Orm\Id
     * @Orm\GeneratedValue(strategy="AUTO")
     * @Orm\Column(type="integer")
     */
    protected $act_actividad_general_id;

    /**
     * @Orm\Column(type="string")
     */
    protected $fecha;    
    
    /**
     * @Orm\Column(type="float")
     */
    protected $duracion;

    /**
     * @Orm\Column(type="string")
     * @ORM\Column(length=40)
     */
    protected $motivo;
   
    /**
     * @Orm\Column(type="string")
     */
    protected $lugar; 

    /**
     * @Orm\Column(type="string")
     */
    protected $temas_tratados;

    /**
     * @Orm\Column(type="string")
     */
    protected $resoluciones;

    /**
     * @Orm\Column(type="string")
     */
    protected $observaciones;
    
    
    /**
     * @Orm\OneToMany(targetEntity="Actividad\Actividad\Participante", mappedBy="actividad")
     */
    protected $participantes;
    
    public function getParticipantes()
    {
        return $this->participantes;
    }
    
    public function __construct()
    {
        $this->participantes = new ArrayCollection();
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
            'fecha' => array(
                'name'      => 'fecha',
                'required'  => false,
                'validator' => array(
                    array('name'    => 'Date',
                          'options' => array('format'   => 'yyyy-MM-dd',
                                             'message'  => 'No es una fecha valida. El formato tiene que ser anho-mes-dia'
                                             )
                          )
                )
            ),   
            'duracion' => array(
                'name'       => 'duracion',
                'required'   => false,
            ),  
            'motivo' => array(
                'name'     => 'motivo',
                'required' => false,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'Alpha'),
                ),
                'validator' => array(
                    array('name'    => 'StringLength', 
                          'options' => array('max' => 40, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),       
            'lugar' => array(
                'name'      => 'lugar',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validator' => array(
                    array('name'    => 'StringLength', 
                          'options' => array('max' => 250, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ), 
            'temas_tratados' => array(
                'name'      => 'temas_tratados',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validator' => array(
                    array('name'    => 'StringLength', 
                          'options' => array('max' => 250, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ), 
            'resoluciones' => array(
                'name'      => 'resoluciones',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validator' => array(
                    array('name'    => 'StringLength', 
                          'options' => array('max' => 250, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ), 
            'observaciones' => array(
                'name'      => 'observaciones',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validator' => array(
                    array('name'    => 'StringLength', 
                          'options' => array('max' => 250, 'message' => 'Solo se permiten %max% caracteres')),
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
        return $this->act_actividad_general_id;
    }
}