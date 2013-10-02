<?php

namespace Actividad\ActividadTipo;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;

/**
 * Tipo de Actividad
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="act_actividad_tipo")
 */
class ActividadTipo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $act_actividad_tipo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $act_nivel_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $act_modalidad_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $act_criterio_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $codigo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $subtitulo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $atelier;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $asistencia;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $duracion;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $fecha_baja;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $fecha_alta;
    
    /**
     * Input Filter
     * @param array $data
     */
    protected function getInputFilter($data)
    {
        $inputFilterFactory = new InputFilterFactory();
        $spec = array(
            'act_nivel_id' => array(
                'name'     => 'act_nivel_id',
                'required' => true,
            ),
            'act_modalidad_id' => array(
                'name'     => 'act_modalidad_id',
                'required' => true,
            ),
            'act_criterio_id' => array(
                'name'     => 'act_criterio_id',
                'required' => true,
            ),
            'codigo' => array(
                'name'       => 'codigo',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 80, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'nombre' => array(
                'name'       => 'nombre',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 100, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
            'subtitulo' => array(
                'name'     => 'subtitulo',
                'required' => false,
            ),
            'atelier' => array(
                'name'       => 'atelier',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty', 'options' => array('message' => 'El campo es Obligatorio')),
                    array('name' => 'Regex', 'options' => array('pattern' => "/^(S|N)$/", 'message' => 'El valor debe ser S (Si) o N (No)')),
                )
            ),
            'asistencia' => array(
                'name'       => 'asistencia',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty', 'options' => array('message' => 'El campo es Obligatorio')),
                    array('name' => 'Regex', 'options' => array('pattern' => "/^(S|N)$/", 'message' => 'El valor debe ser S (Si) o N (No)')),
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                )
            ),
            'duracion' => array(
                'name'     => 'duracion',
                'required' => false,
                'validators' => array(
                    array('name' => 'GreaterThan', 'options' => array('min' => 0, 'message' => 'La duracion debe ser mayor a cero')),
                )
            ),
            'fecha_baja' => array(
                'name'     => 'fecha_baja',
                'required' => false,
            ),
            'fecha_alta' => array(
                'name'     => 'fecha_alta',
                'required' => false,
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
        return $this->act_actividad_tipo_id;
    }
}