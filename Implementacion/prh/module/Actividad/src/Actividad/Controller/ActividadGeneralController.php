<?php

namespace Actividad\Controller;

use Actividad\ActividadGeneral\QueryObject\Select;
use Actividad\ActividadGeneral\QueryObject\Get;
use Actividad\ActividadGeneral\QueryObject\Participantes;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

class ActividadGeneralController extends BaseController {
	
	public function indexAction($overwritedParams = array())
	{
		$select 	= new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao 		= new Dao($select);
		$template 	= $this->_crearTemplateParaListado();

		return $template($dao, array(), $overwritedParams);
	}

    public function getAction()
    {
        $query 		= new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao 		= new DaoGet($query);
        $template 	= $this->_crearTemplateParaGet();

        return $template($dao, array());
    }

    public function participantesAction($overwritedParams = array())
    {
        $select 	= new Participantes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao 		= new Dao($select);
        $template 	= $this->_crearTemplateParaListado();

        return $template($dao, array(), $overwritedParams);
    }

}