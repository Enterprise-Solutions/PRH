<?php

namespace Actividad\Controller;

use Actividad\RelacionAyuda\QueryObject\Get;
use Actividad\RelacionAyuda\QueryObject\Participante;
use Actividad\RelacionAyuda\QueryObject\Select;
use Actividad\RelacionAyuda\Service\Crear as CrearRelacionAyudaService;
use Actividad\RelacionAyuda\Service\Eliminar as EliminarRelacionAyudaService;
use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

class RelacionAyudaController extends BaseController
{
    public function indexAction($overwritedParams = array())
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array('s' => array('prefijo' => $this->getPrefijo())), $overwritedParams);
    }
    
    public function getAction()
    {
        $query = new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new DaoGet($query);
        $template = $this->_crearTemplateParaGet();
        return $template($dao, array());
    }
    
    protected function getLoggedUser()
    {
        return $this->getServiceLocator()->get('Identidad');
    }
    
    protected function getPrefijo()
    {
        $loggedUser = $this->getLoggedUser();
        $prefijo = substr(strtoupper($loggedUser->nombre_persona),0,1) .
                   substr(strtoupper($loggedUser->apellido_persona),0,1) .
                   $loggedUser->org_parte_id;
        
        return $prefijo;
    }
    
    public function listarParticipantesAction($overwritedParams = array())
    {
        $select = new Participante($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->setPrefijoIdentificador($this->getPrefijo());
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearRelacionAyudaService($em);
        $service->setLoggedUser($this->getLoggedUser());
        $service->setPrefijoIdentificador($this->getPrefijo());
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    public function deleteAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('delete');
        
        $service = new EliminarRelacionAyudaService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    /**
     * Doctrine Entity Manager
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
}