<?php
namespace OrgTest\Contacto;
use Org\Contacto\Factory;

use Org\Contacto\Repository;
use Org\Contacto\Service;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class ContactosTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var EntityManager
	 */
	protected $_em;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$this->_em = $sm->get('doctrine.entitymanager.orm_default');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_em = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testRepository()
	{
		$repository = new Repository($this->_em);
		$tipoDeContacto = $repository->getTipoDeContacto('celularlab');
		$this->assertInstanceOf('Org\Contacto\TipoDeContacto', $tipoDeContacto);
		$tipoDeContacto = $repository->getTipoDeContacto('celularpart');
		$this->assertInstanceOf('Org\Contacto\TipoDeContacto', $tipoDeContacto);
		$rs = $repository->findContactosByOrgParteId(1);
		$this->assertEquals(2, count($rs));
	}
	
	public function testFactory()
	{
		/*$repository = new Repository($this->_em);
		$factory = new Factory($repository);
		$contacto = $factory->crearContacto('celularlab');
		$this->assertInstanceOf('Org\Contacto\Contacto', $contacto);
		$this->assertInstanceOf('Org\Contacto\Contacto\CelularLab',$contacto);
		$repositoryDePartes = new \Org\Parte\Repository($this->_em);
		$parte = $repositoryDePartes->get(1);
		$contacto->setParte($parte);
		$contacto->crear(array('contacto' => '0971-444444'));
		$repository->persistir(array($contacto));
		$this->_em->flush();*/
	}
	
	public function testService()
	{
		$repository = new Repository($this->_em);
		$factory = new Factory($repository);
		$service = new Service($factory,$repository);
		$repositoryDePartes = new \Org\Parte\Repository($this->_em);
		$parte = $repositoryDePartes->get(1);
		$datos = array('org_parte' => $parte, 'Contactos' => array('agregados' => array(array('org_contacto_tipo_codigo' => 'celularlab','contacto' => '0981666666'))));
		$service->ejecutar($datos);
		$this->_em->flush();
	}
}

