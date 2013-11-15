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
        //$resultado = service\ejecutar($this->_repository, array('org_parte_id' => 3,'act_actividad_id' => 2));
        //print_r($resultado);
        $string = '<p><img src="http://www.champs.com.py/Content/Images/uploaded/mailing/logo.gif" height="63" width="232" /></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Hola,</span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Hemos recibido su solicitud de registro. Para activar su cuenta por favor haga click en el siguiente enlace:</span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;"><a href="%Customer.AccountActivationURL%">%Customer.AccountActivationURL%</a></span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Si el enlace no funciona puede copiar el enlace y pegarlo manualmente en otra ventana de su navegador.</span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;"><br /></span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Atentamente, El equipo de Champs Elys&egrave;es.</span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">----------------------------------------------------------------------------------</span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;"><a href="http://www.champs.com.py">www.champs.com.py</a></span></p>

<p><span style="font-family: arial, helvetica, sans-serif; font-size: small;">----------------------------------------------------------------------------------</span></p>

<p><span style="font-size: small;">Ayuda telef&oacute;nica: 021 441 804 - 0982 840382</span></p>';
        $string = html_entity_decode($string);
        print_r(strip_tags($string));
    }
}

