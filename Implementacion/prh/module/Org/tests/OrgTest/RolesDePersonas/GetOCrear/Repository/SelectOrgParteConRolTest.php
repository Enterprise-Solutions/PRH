<?php
namespace OrgTest\RolesDePersonas\GetOCrear\Repository;
use PHPUnit_Framework_TestCase;
use OrgTest\Bootstrap;
use Org\RolesDePersonas\GetOCrear\Repository\SelectOrgParteConRol as Select;
/**
 * test case.
 */
class SelectOrgParteConRolTest extends PHPUnit_Framework_TestCase
{
    public $_select;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $sm = Bootstrap::getServiceManager();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $this->_select = new Select($dbAdapter);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        ob_flush();
        $this->_select = null;
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
    
    public function testEjecutar()
    {
        //$this->_select->addSearchByOrgParteId(3);
        //$this->_select->addSearchByOrgRolCodigo('participante');
        $rs = $this->_select->execute()->toArray();
        print_r($rs);
    }
}

