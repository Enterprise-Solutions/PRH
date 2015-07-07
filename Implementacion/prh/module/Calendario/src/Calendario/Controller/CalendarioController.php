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

use Calendario\Calendario\Service\Listado\Select as SelectDeCalendarios;

class CalendarioController extends BaseController
{
    public function indexAction()
    {
        $select = new SelectDeCalendarios($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao,array(),array());
    }

}
