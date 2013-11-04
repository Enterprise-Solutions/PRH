<?php
namespace AdmTest\Usuario\Service\DocumentosParaLogin;
use Adm\Usuario\Service\DocumentosParaLogin\Select;
use PHPUnit_Framework_TestCase;

use AdmTest\Bootstrap;

/**
 * test case.
 */
class DocumentosParaLoginSelectTest extends PHPUnit_Framework_TestCase {
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
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testEjecucion()
	{
		$this->_select->addSearchByOrgParteId(4);
		$rs = $this->_select->execute();
		print_r($rs->toArray());
	} 
}

