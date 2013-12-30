<?php

namespace Actividad\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Select;
use EnterpriseSolutions\Db\Dao;

class CombosController extends BaseController
{
	public function actCicloAction()
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$select->_select->from('act_ciclo');
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao);
	}
	
	public function actActividadTipoAction()
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->_select->from('act_actividad_tipo')->columns(array('act_actividad_tipo_id', 'nombre'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao);
    }
    
    public function contMonedaAction()
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->_select->from('cont_moneda')->columns(array('cont_moneda_id', 'nombre'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao);
    }
    
    public function calAnhoFormacionAction()
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->_select->from('cal_anho_formacion')->columns(array('cal_anho_formacion_id', 'anho'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao);
    }
}