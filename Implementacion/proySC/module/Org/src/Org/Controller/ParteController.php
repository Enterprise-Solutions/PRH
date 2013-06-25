<?php

namespace Org\Controller;

use EnterpriseSolutions\Controller\BaseController;
use Org\Parte\Service\Listado\Select;
use EnterpriseSolutions\Db\Dao;
use Org\Parte\Service\Creacion;
use Org\Parte\Service\Edicion;
use Org\Parte\Service\Transaccional;

class ParteController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao,array(),$overwritedParams);
	}
	
	public function crearAction($orgParteTipoCodigo = null)
	{
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$actionService = new Creacion($em);
		$service = new Transaccional($em,$actionService);
		$datos = $this->SubmitParams()->getParam('post');
		if($orgParteTipoCodigo){
			$datos['org_parte_tipo_codigo'] = $orgParteTipoCodigo;
		}
		$service->ejecutar($datos);
		return $this->_returnAsJson($service->getRespuesta());
	}
	
	public function editarAction()
	{
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$actionService = new Edicion($em);
		$service = new Transaccional($em,$actionService);
		$datos = $this->SubmitParams()->getParam('put');
		$parte = $service->ejecutar($datos);
		return $this->_returnAsJson($service->getRespuesta());
	}
	
	public function _returnAsJson($respuesta)
	{
		$viewModel = $this->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
				'text/html','application/json'
		)));
		$viewModel->setVariables($respuesta);
		return $viewModel;
	}
}