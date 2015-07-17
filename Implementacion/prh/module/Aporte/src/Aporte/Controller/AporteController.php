<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Aporte\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Simple\Repository\DataSource;
use EnterpriseSolutions\Simple\Service\Service as EsService;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;
use Doctrine\ORM\EntityManager;

use Aporte\Aporte\Service\Listado\Select as SelectDeAportes;
use Aporte\Aporte\Service\Get\GetPersona;
use Aporte\Aporte\Service\Get\GetRol;
use Aporte\Aporte\Service\Get\GetAportes;
use Aporte\Aporte\Service\Get\Dao as GetDao;
use Aporte\Aporte\Service\Get\DaoAportes;
use Aporte\Aporte\Service\Creacion;
use Aporte\Aporte\Service\Edicion;
use Aporte\Aporte\Service\Borrado;
use Aporte\Aporte\Repository;

class AporteController extends BaseController
{
    public function indexAction()
    {
        $select     = new SelectDeAportes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao        = new Dao($select);
        $template   = $this->_crearTemplateParaListado();

        return $template($dao,array(),array());
    }

    public function getPersonaAction()
    {
        $persona    = new GetPersona($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao        = new GetDao($persona);
        $template   = $this->_crearTemplateParaGet();

        return $template($dao, array());
    }

    public function getAportesAction()
    {
        $aportes    = new GetAportes($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao        = new DaoAportes($aportes);
        $template   = $this->_crearTemplateParaGet();

        return $template($dao, array());
    }

    public function postAction()
    {
        $adapter    = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $ds         = new DataSource($adapter);
        $repository = new Repository($ds);
        $creacion   = new Creacion($repository);
        $params     = $this->SubmitParams()->getParam('post');
        $service    = function($params) use($creacion){
            return $creacion->ejecutar($params);
        };
        $esService  = new EsService();
        $transaccion= $esService->transaccional($service,$ds);
        $respuesta  = $transaccion($params);
        
        return $this->_returnAsJson($respuesta);
    }

    public function putAction()
    {
		$adapter 	= $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$ds 		= new DataSource($adapter);
		$repository = new Repository($ds);
		$edicion 	= new Edicion($repository);
		$params 	= $this->SubmitParams()->getParam('put');
		$service 	= function($params) use($edicion){
			return $edicion->ejecutar($params);
		};
		$esService 	= new EsService();
		$transaccion= $esService->transaccional($service,$ds);
		$respuesta 	= $transaccion($params);

		return $this->_returnAsJson($respuesta);
    }

    public function deleteAction()
    {
        $adapter    = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $ds         = new DataSource($adapter);
        $repository = new Repository($ds);
        $borrado    = new Borrado($repository);
        $params     = $this->SubmitParams()->getParam('delete');
        $service    = function($params) use($borrado){
            return $borrado->ejecutar($params);
        };
        $esService  = new EsService();
        $transaccion= $esService->transaccional($service,$ds);
        $respuesta  = $transaccion($params);

        return $this->_returnAsJson($respuesta);
    }

}
