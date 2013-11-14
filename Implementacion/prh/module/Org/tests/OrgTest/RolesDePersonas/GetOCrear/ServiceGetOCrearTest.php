<?php
namespace OrgTest\RolesDePersonas\GetOCrear;
require_once 'Implementacion/prh/module/Org/src/Org/RolesDePersonas/GetOCrear/Service.php';
use PHPUnit_Framework_TestCase;
use OrgTest\Bootstrap;
use Org\RolesDePersonas\GetOCrear\Repository;
use EnterpriseSolutions\Simple\Repository\DataSource;
use Org\RolesDePersonas\GetOCrear\Service as s;
/**
 * test case.
 */
class ServiceGetOCrearTest extends PHPUnit_Framework_TestCase
{
    public $_repository;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $sm = Bootstrap::getServiceManager();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $ds = new DataSource($dbAdapter);
        $this->_repository = new Repository($ds);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        ob_flush();
        $this->_repository = null;
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
    
    public function testCrearOrgParteRolParaPersonaSinElRol()
    {
        //$resultado = s\ejecutar($this->_repository, array('org_parte_id' => 3,'org_rol_codigo' => 'participante'));
        //print_r($resultado);
    }
    
    public function testGetOrgParteRolParaPersonaConElRol()
    {
        $resultado = s\ejecutar($this->_repository, array('org_parte_id' => 3,'org_rol_codigo' => 'participante'));
        print_r($resultado);
    }
}

