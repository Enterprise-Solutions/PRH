<?php

namespace Actividad\Controller;

use Actividad\ActividadGeneral\QueryObject\Select;
use Actividad\ActividadGeneral\QueryObject\Get;
use Actividad\ActividadGeneral\QueryObject\Partes;
use Actividad\ActividadGeneral\QueryObject\Participantes;
use Actividad\ActividadGeneral\Service\Crear as CrearActividad;
use Actividad\ActividadGeneral\Service\Editar as EditarActividad;
use Actividad\ActividadGeneral\Service\AsociarParticipante;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;
use EnterpriseSolutions\Simple\Repository\DataSource;
use EnterpriseSolutions\Exceptions\Thrower;

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

    public function postAction()
    {
        $em 		= $this->getEntityManager();
        $data 		= $this->SubmitParams()->getParam('post');
        
        $service 	= new CrearActividad($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }

    public function putAction()
    {
        $dbAdapter	= $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $em 		= $this->getEntityManager();
        $data 		= $this->SubmitParams()->getParam('put');
        
        $service 	= new EditarActividad($em, $dbAdapter);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }

    public function listarPartesAction($overritedParams = array())
    {
        $query 		= new Partes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao 		= new Dao($query);
        $template 	= $this->_crearTemplateParaListado();

        return $template($dao, array(), $overritedParams);
    }

    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
}