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
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $modalidad;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $titulo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=250)
     */
    protected $descripcion;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $relacion_ayuda;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $homologada;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $activo;
    
    /**
     * Input Filter
     * @param array $data
     */
    protected function getInputFilter($data)
    {
        $inputFilterFactory = new InputFilterFactory();
        $spec = array(
            'modalidad' => array(
                'name'       => 'modalidad',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
                	array('name' => 'Regex', 'options' => array('pattern' => "/^(H|D)$/", 'message' => 'El valor debe ser D (Dias de Formacion) o H (Horas de Formacion)')),
                ),
            ),
            'titulo' => array(
                'name'       => 'titulo',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 100, 'message' => 'Solo se permiten %max% caracteres')),
                ),
            ),
        	'descripcion' => array(
        		'name'       => 'descripcion',
        		'required'   => false,
        		'filters'    => array(
        			array('name' => 'StripTags'),
        		),
        		'validators' => array(
        			array('name' => 'StringLength', 'options' => array('max' => 250, 'message' => 'Solo se permiten %max% caracteres')),
        		),
        	),
        	'relacion_ayuda' => array(
        		'name'       => 'relacion_ayuda',
        		'required'   => false,
        		'filters'    => array(
        			array('name' => 'StripTags'),
        		),
        		'validators' => array(
        			array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
        			array('name' => 'Regex', 'options' => array('pattern' => "/^(S|N)$/", 'message' => 'El valor debe ser S (Si) o N (No)')),
        		),
        	),
        	'homologada' => array(
        		'name'       => 'homologada',
        		'required'   => false,
        		'filters'    => array(
        			array('name' => 'StripTags'),
        		),
        		'validators' => array(
        			array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
        			array('name' => 'Regex', 'options' => array('pattern' => "/^(S|N)$/", 'message' => 'El valor debe ser S (Si) o N (No)')),
        		),
        	),
        	'activo' => array(
        		'name'       => 'activo',
        		'required'   => false,
        		'filters'    => array(
        			array('name' => 'StripTags'),
        		),
        		'validators' => array(
        			array('name' => 'StringLength', 'options' => array('max' => 1, 'message' => 'Solo se permiten %max% caracteres')),
        			array('name' => 'Regex', 'options' => array('pattern' => "/^(S|N)$/", 'message' => 'El valor debe ser S (Si) o N (No)')),
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
        return $this->act_actividad_tipo_id;
    }
}