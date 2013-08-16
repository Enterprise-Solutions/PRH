<?php

namespace Actividad\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

use Actividad\Actividad\QueryObject\Select;
use Actividad\Actividad\QueryObject\Get;
use Actividad\Actividad\Service\Crear as CrearActividadService;
use Actividad\Actividad\Service\Editar as EditarActividadService;
use Actividad\Actividad\Service\Eliminar as EliminarActividadService;

class ActividadController extends BaseController
{
    public function indexAction($overwritedParams = array())
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function getAction()
    {
        $query = new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new DaoGet($query);
        $template = $this->_crearTemplateParaGet();
        return $template($dao, array());
    }
    
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearActividadService($em);
        $service->ejecutar($data);
        $this->getEntityMangaer()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function putAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('put');
        
        $service = new EditarActividadService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function deleteAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('delete');
        
        $service = new EliminarActividadService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
}