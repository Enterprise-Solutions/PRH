<?php
namespace OrgTest\Documento;
require_once 'Implementacion/proySC/module/Org/src/Org/Documento/Documentos.php';
use Org\Documento\Documentos\crearDocumentoParaParte;

use Org\Documento\Repository;
use Org\Parte\Repository as parteRepo;

use Org\Documento\Documento\Factory;
use Org\Documento\Documentos as f;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class DocumentosDeParteTest extends PHPUnit_Framework_TestCase {
	
	public $_parte;
	public $_factory;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$repository = new Repository($em);
		$this->_factory = new Factory($repository);
		$parteRepo = new parteRepo($em);
		$this->_parte = $parteRepo->get(42);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_documentosDeParte = null;
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCrearDocumentoParaParte()
	{
		//crearDocumentoParaParte($datos, $parte, $docFactory)
		$documento = f\crearDocumentoParaParte(
			array('org_documento_tipo_codigo' => 'ruc','valor' => '1284047-5'),
			$this->_parte,
			$this->_factory
		);
		$this->assertInstanceOf('Org\Documento\Documento', $documento);
		//$this->_assertInstanceOf('Org\Documento\Documento',$documento);
	}
	
	public function testAgregarDocumentosAListadoDeParte()
	{
		$listado = array();
		$datosArray = array(array('org_documento_tipo_codigo' => 'ruc','valor' => '1284047-5'));
		$listado = f\agregarDocumentosAListadoDeParte($datosArray, $listado, $this->_parte, $this->_factory);
		$this->assertCount(1, $listado);
		$documento = current($listado);
		$this->assertInstanceOf('Org\Documento\Documento', $documento);
	}
	
}

