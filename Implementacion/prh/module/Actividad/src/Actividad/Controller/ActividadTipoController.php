<?php

namespace Actividad\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

use Actividad\ActividadTipo\QueryObject\Select;
use Actividad\ActividadTipo\QueryObject\Get;
use Actividad\ActividadTipo\Service\Crear as CrearActividadTipoService;
use Actividad\ActividadTipo\Service\Editar as EditarActividadTipoService;
use Actividad\ActividadTipo\Service\Eliminar as EliminarActividadTipoService;

use EnterpriseSolutions\Exceptions\Thrower;

class ActividadTipoController extends BaseController
{
    public function indexAction($overwritedParams = array('p' => array('page' => 0, 'limit' => 3)))
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
        return $template($dao, array('id' => 5));
    }
    
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearActividadTipoService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function putAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('put');
        
        $service = new EditarActividadTipoService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function deleteAction()
    {
        $em = $this->getEntityManager();
        //$data = $this->SubmitParams()->getParam('delete');
        $data = array('act_actividad_tipo_id' => 143);
        
        $service = new EliminarActividadTipoService($em);
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