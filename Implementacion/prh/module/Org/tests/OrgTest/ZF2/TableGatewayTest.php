<?php
namespace OrgTest;
use Zend\Db\TableGateway\Feature\MetadataFeature;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\RowGateway\RowGateway;
/**
 * test case.
 */
class TableGatewayTest extends PHPUnit_Framework_TestCase {
	public $_tableGateway;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$features = new Feature\FeatureSet();
		$features->addFeature(new MetadataFeature());
		$features->addFeature(new RowGatewayFeature());
		$this->_tableGateway = new TableGateway('org_estado_civil', $dbAdapter,$features);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_tableGateway = null;
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
		//$rs = $this->_tableGateway->select();
		//print_r($rs->toArray());
	}
	
	public function testInsert()
	{
		//$rs = $this->_tableGateway->insert(array('nombre' => 'Casado'));
		
		$rs = $this->_tableGateway->select(array('org_estado_civil_id' => 2));
		$row = $rs->current();
		$row->populate(array('org_estado_civil_id' => 2,'nombre' => 'Viudo'),true);
		$row->save();
	}
}

