<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Calendario\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Simple\Repository\DataSource;
use EnterpriseSolutions\Simple\Service\Service as EsService;
use EnterpriseSolutions\Db\Dao\Get as GetDao;
use Doctrine\ORM\EntityManager;

use Calendario\Calendario\Service\Listado\Select as SelectDeCalendarios;
use Calendario\Calendario\Service\Creacion;
use Calendario\Calendario\Service\Edicion;
use Calendario\Calendario\Service\Borrado;
use Calendario\Calendario\Repository;

class CalendarioController extends BaseController
{
    public function indexAction()
    {
        $select     = new SelectDeCalendarios($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao        = new Dao($select);
        $template   = $this->_crearTemplateParaListado();

        return $template($dao,array(),array());
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
