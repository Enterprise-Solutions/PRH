<?php
namespace OrgTest;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Parte\Service\Creacion;
use Org\Parte\Service\Edicion;
use Org\Parte\Service\Transaccional;

/**
 * test case.
 */
class CreacionTest extends PHPUnit_Framework_TestCase {
	public $_service;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		//$service = new Creacion($em);
		$service = new Edicion($em);
		$this->_service = new Transaccional($em,$service);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated CreacionTest::tearDown()
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCreaPersonaYPersiste()
	{
		//$datos = array('org_parte_tipo_codigo' => 'per','nombre' => 'Pablo','apellido' => 'Islas','fechaDeNacimiento' => '01-12-1979','genero' => 'H');
		/*$datos = array('org_parte_tipo_codigo' => 'per','nombre' => 'Pablo','apellido' => 'Marmol','fechaDeNacimiento' => '01-12-1979','genero' => 'H','Contactos' => array('agregados' => array(array('org_contacto_tipo_codigo' => 'celularlab','contacto' => '0971234567'))),
			'Direcciones' => array('editados' => array(array('direccion' => 'Rio Pilcomayo 645','dir_barrio_id' => 1)))			
		);*/
		$datos = array('org_parte_id' => 2,
				'Profesiones' => array('agregados' => array(array('org_profesion_id' => 2)))
		);
		$parte = $this->_service->ejecutar($datos);
		$this->assertInstanceOf('Org\Parte\Persona\Persona', $parte);
		$this->assertNotNull($parte->getId());
		
	}
	
	/*public function testCreaYPersisteOrg()
	{
		$datos = array('org_parte_tipo_codigo' => 'org','nombre' => 'Enterprise Solutions');
		$parte = $this->_service->ejecutar($datos);
		$this->assertInstanceOf('Org\Parte\Organizacion\Organizacion', $parte);
		$this->assertNotNull($parte->getId());
	}*/
}

