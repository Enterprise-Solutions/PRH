<?php

namespace Aporte\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Select;
use EnterpriseSolutions\Db\Dao;

class CombosController extends BaseController
{
    public function aportesTiposAction()
    {
        $select    	= new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->_select
        	   ->from('ap_aporte_tipo')
        	   ->columns(array('ap_aporte_tipo_id', 'nombre'));
        $dao       	= new Dao($select);
        $template 	= $this->_crearTemplateParaListado();

        return $template($dao);    
    }

    public function rolesTiposAction()
    {
        $select    	= new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $id 		= $this->SubmitParams()->getParam('id');
        $select->_select
        	   ->from(array('rs' => 'org_parte_rol_socio'))
        	   ->columns(array('org_parte_rol_socio_id'))
        	   ->join(
                array('rst' => 'org_parte_rol_socio_tipo'), 
                'rs.org_parte_rol_socio_tipo_id = rst.org_parte_rol_socio_tipo_id',
                array('nombre')
               )
        	   ->where("rs.org_parte_rol_id = $id");
        $dao       = new Dao($select);
        $template  = $this->_crearTemplateParaListado();

        return $template($dao);    
    }   

    public function monedaTiposAction()
    {
        $select    	= new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $select->_select
        	   ->from('cont_moneda')
        	   ->columns(array('cont_moneda_id', 'nombre'));
        $dao       	= new Dao($select);
        $template 	= $this->_crearTemplateParaListado();

        return $template($dao);      	
    }
}