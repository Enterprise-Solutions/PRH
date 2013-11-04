<?php
namespace OrgTest;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Parte\Service\Borrado\Select;
/**
 * test case.
 */
class SelectDeParteABorrarTest extends PHPUnit_Framework_TestCase {
	
	public $_select;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$this->_select = new Select($dbAdapter);
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
	
	public function testSelect()
	{
		$rs = $this->_select->execute()->toArray();
		print_r($rs);
	}
}

