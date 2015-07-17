<?php

namespace Aporte\Aporte\Service\Listado;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as DbSelect;

class SelectAportes extends DbSelect
{
    
    public function _init()
    {
        $_s = ",!";
        $this->_select
             ->from(array('apd' => 'ap_aporte_detalle'))
             ->columns(array('ap_aporte_detalle_id', 'monto', 'fecha'))
             ->join(
                array('cm' => 'cont_moneda'), 
                'apd.cont_moneda_id = cm.cont_moneda_id',
                array('moneda' => 'simbolo'),
                ZFSelect::JOIN_LEFT
               )
             ->join(
                array('apt' => 'ap_aporte_tipo'), 
                'apd.ap_aporte_tipo_id = apt.ap_aporte_tipo_id',
                array('tipo' => 'nombre'),
                ZFSelect::JOIN_LEFT
               )
             ->join(
                array('opr' => 'org_parte_rol'), 
                'apd.org_parte_rol_cargador_id = opr.org_parte_rol_id',
                array(),
                ZFSelect::JOIN_LEFT
               )                            
             ->join(
                array('rs' => 'org_parte_rol_socio'), 
                'opr.org_parte_rol_id = rs.org_parte_rol_id',
                array(),
                ZFSelect::JOIN_LEFT
               )   
             ->join(
                array('rst' => 'org_parte_rol_socio_tipo'), 
                'rs.org_parte_rol_socio_tipo_id = rst.org_parte_rol_socio_tipo_id',
                array('rol_socio' => 'nombre'),
                ZFSelect::JOIN_LEFT
               );                                        
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("apd.org_parte_rol_cargador_id = $id");
        }
    }
}