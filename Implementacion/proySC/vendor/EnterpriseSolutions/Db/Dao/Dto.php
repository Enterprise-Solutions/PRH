<?php

namespace EnterpriseSolutions\Db\Dao;

class Dto {
	public $_params = array();
	public function __construct($params = array())
	{
		$this->_params = $params;
	}
	
	public function getOffset()
	{
	    if(isset($this->_params['p']['page'])){
	    	return $this->_params['p']['page'];
	    }
	    return null;
	}
	
	public function getCantidadPorPagina()
	{
		if(isset($this->_params['p']['limit'])){
	    	return $this->_params['p']['limit'];
	    }
	    return null;
	}
	
	public function getParametrosDeBusqueda()
	{
        if(isset($this->_params['s'])){
        	return $this->_params['s'];
        }
        return array();
	}
	
	public function getParametrosDeOrdenamiento()
	{
		if(isset($this->_params['o'])){
			return $this->_params['o'];
		}
		return array();
	}
}