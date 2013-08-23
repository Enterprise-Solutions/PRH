<?php

namespace Actividad\Actividad;

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
     * @Orm\Column(type="string")
     */
    protected $fecha_inicio;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $fecha_fin;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $nombre_identificador;
    
    /**
     * @Orm\Column(type="float")
     */
    protected $duracion;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $estado;
    
    /**
     * @Orm\Column(type="float")
     */
    protected $monto;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $observaciones;
    
    /**
     * @Orm\Column(type="string")
     */
    protected $tipo;
    
    /**
     * @Orm\Column(type="integer")
     */
    protected $nro_personas;
    
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
            'nombre_identificador' => array(
                'name'      => 'nombre_identificador',
                'required'  => false,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'Alpha'),
                ),
                'validator' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 100)),
                ),
            ),
            'duracion' => array(
                'name'       => 'duracion',
                'required'   => false,
            ),
            'estado' => array(
                'name'       => 'estado',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'StringLength', 'options' => array('max' => 1)),
                ),
            ),
            'monto' => array(
                'name'      => 'monto',
                'required'  => false,
            ),
            'observaciones' => array(
                'name'      => 'observaciones',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
            ),
            'tipo' => array(
                'name'      => 'tipo',
                'required'  => false,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'StringLength', 'options' => array('max' => 1)),
                ),
            ),
            'nro_personas' => array(
                'name'      => 'nro_personas',
                'required'  => false,
                'validators' => array(
                    array('name' => 'Digits', 'options' => array('message' => 'Esta mal')),
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
            Thrower::throwValidationException('Error de Validacion', $inputFilter->getMessages());
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