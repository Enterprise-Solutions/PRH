<?php

namespace Actividad\Controller;

use EnterpriseSolutions\Controller\BaseController;

class ActividadGeneralController extends BaseController {
	
	public function indexAction($overwritedParams = array())
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao, array(), $overwritedParams);
	}
}