<?php
namespace OrgTest\Parte\Service\Borrado;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Parte\Service\Borrado\Repository;
use EnterpriseSolutions\Simple\Repository\DataSource;
/**
 * test case.
 */
class RepositoryDeBorradoTest extends PHPUnit_Framework_TestCase {
	
	public $_repository;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$ds = new DataSource($dbAdapter);
		$this->_repository = new Repository($ds);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_select = null;
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testFind()
	{
		$partes = $this->_repository->findPartes(array(1,2,3));
		print_r($partes);
	}
}

