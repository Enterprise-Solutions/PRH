<?php

namespace ActividadTest\Controller;
use Actividad\Actividad\QueryObject\Select;
use ActividadTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\Db\Adapter\Driver\Pdo\Result;
use Actividad\Actividad;
use EnterpriseSolutions\Db;


/**
 * test case.
 */
class ActividadTest extends PHPUnit_Framework_TestCase {
	
	protected $_select;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		//Obtiene el Adaptador configurado en el global.php
		$sm      = Bootstrap::getServiceManager();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
		
		$select = new Select($adapter);
		$rt = $select->execute();
		
		
		//Obtiene el Adaptador configurado en el global.php
		$sm      = Bootstrap::getServiceManager();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
		
		//Se crea el query
		$sql     = 'select * from org_rol';
		
		//Se crea el statement y se ejecuta el query
		$stmt    = $adapter->query($sql);
		$results = $stmt->execute();
		
		//Se traen los resultados
		$sizeResult = $results->count();
		$registros = array();
		for($i=0;$i<$sizeResult;$i++)
		{
			$registros[] = $results->current();
			$results->next();
		}
		
		$actividad = new \Actividad\Actividad\Actividad();
		$datos = array('act_actividad_tipo_id'=>1,'cont_moneda_id'=>1,'cal_anho_formacion_id'=>1,
				'fecha_inicio'=>'2013-08-03','fecha_fin'=>'2013-08-04','nombre_identificador'=>'pepe',
				'duracion'=>23.5,"estado"=>'A',"monto"=>34.5,"observaciones"=>"hola","tipo"=>'R','nro_personas'=>5);
		$lo = $actividad->fromArray($datos);
		
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testIndex()
	{
		
	}
}


