<?php

namespace Actividad\Controller;

use Actividad\ActividadGeneral\QueryObject\Select;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;

class ActividadGeneralController extends BaseController {
	
	public function indexAction($overwritedParams = array())
	{
		$select 	= new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao 		= new Dao($select);
		$template 	= $this->_crearTemplateParaListado();

		return $template($dao, array(), $overwritedParams);
	}
}