<?php
namespace ActividadTest\Actividad\Service\AgregarParticipante;
require_once 'Implementacion/prh/module/Actividad/src/Actividad/Actividad/Service/AgregarParticipante.php';
use PHPUnit_Framework_TestCase;
use ActividadTest\Bootstrap;
use EnterpriseSolutions\Simple\Repository\DataSource;
use Actividad\Actividad\Service\AgregarParticipante\Repository;
use Actividad\Actividad\Service\AgregarParticipante as service;
//use Actividad\Actividad\Service\AgregarParticipante\ejecutar;
/**
 * test case.
 */
class FindparticipanteDeActividadTest extends PHPUnit_Framework_TestCase
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
    
    public function testFindConOrgParteIdNoParticipanteRetornaFalse()
    {
        //$this->assertFalse($this->_repository->findParticipanteDeActividad(3, 2));
    }
    
    public function testFindConOrgParteIdParticipanteRetornaActActividadParticipantesId()
    {
        /*$resultado = $this->_repository->findParticipanteDeActividad(3, 1);
        $this->assertGreaterThan(0, $resultado);
        print_r($resultado);*/
    }
    
    public function testAgregarNuevoParticipanteAActividadCrearActActividadParticipantesId()
    {
        $resultado = service\ejecutar($this->_repository, array('org_parte_id' => 3,'act_actividad_id' => 2));
        print_r($resultado);
    }
}

