<?php

namespace Actividad\Controller;

use Actividad\RelacionAyuda\QueryObject\Get;
use Actividad\RelacionAyuda\QueryObject\Select;
use Actividad\RelacionAyuda\Service\Crear as CrearRelacionAyudaService;
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
        
        $service = new CrearRelacionAyudaService($em);
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