<?php

namespace Actividad\Controller;
use Actividad\Actividad\Actividad;

use Actividad\Actividad\QueryObject\Select;
use Actividad\Actividad\QueryObject\Partes;
use Actividad\Actividad\QueryObject\Formadores;
use Actividad\Actividad\QueryObject\Participantes;
use Actividad\Actividad\QueryObject\Get;
use Actividad\Actividad\Service\Crear as CrearActividadService;
use Actividad\Actividad\Service\Editar as EditarActividadService;
use Actividad\Actividad\Service\Eliminar as EliminarActividadService;
use Actividad\Actividad\Service\AsociarFormador as AsociarFormadorService;
use Actividad\Actividad\Service\DesasociarFormador as DesasociarFormadorService;
use Actividad\Actividad\Service\AsociarParticipante as AsociarParticipanteService;
use Actividad\Actividad\Service\DesasociarParticipante as DesasociarParticipanteService;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

use Actividad\Actividad\Service\AgregarParticipante;
use Actividad\Actividad\Service\AgregarParticipante\Repository as repositoryParticipantes;
use EnterpriseSolutions\Simple\Repository\DataSource;
use EnterpriseSolutions\Exceptions\Thrower;

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
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function putAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('put');
        
        $service = new EditarActividadService($em, $dbAdapter);
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
    
    public function listarPartesAction($overritedParams = array())
    {
        $listarPartes = new Partes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($listarPartes);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overritedParams);
    }
    
    public function asociarFormadorAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParams();
        
        $service = new AsociarFormadorService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function desasociarFormadorAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParams();
        
        $service = new DesasociarFormadorService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function asociarParticipanteAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParams();
        
        $service = new AsociarParticipanteService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function desasociarParticipanteAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParams();
        
        $service = new DesasociarParticipanteService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function formadoresAction($overwritedParams = array())
    {
        $select = new Formadores($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function participantesAction($overwritedParams = array())
    {
        $select = new Participantes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
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
    
    /**
     * {org_parte_id:int,act_actividad_id:int}
     * @return
     */
    public function setParticipanteAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $ds = new DataSource($dbAdapter);
        $repository = new repositoryParticipantes($ds);
        $params = $this->SubmitParams()->getParam('post');
        if(!$params){
            Thrower::throwValidationException('Formato invalido de parametros, se espera {post:{org_parte_id:int,act_actividad_id:int}}');
        }
        $service = function($params) use($repository){
            $service = new AgregarParticipante();
        	return $service->ejecutar($repository, $params);
        };
        return $this->_returnAsJson($service($params));
    }
}