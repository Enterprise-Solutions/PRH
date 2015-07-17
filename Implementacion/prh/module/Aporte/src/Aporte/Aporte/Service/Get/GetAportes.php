<?php

namespace Aporte\Aporte\Service\Get;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as ZFSelect;
use EnterpriseSolutions\Db\Select as DbSelect;

class GetAportes extends DbSelect
{
    
    public function _init()
    {
        $_s = ",!";
        $this->_select
             ->from(array('apd' => 'ap_aporte_detalle'))
             ->columns(
                array('org_parte_rol_cargador_id',
                'detalles'   => new Expression("string_agg(distinct 
                                            'ap_aporte_detalle_id:'||apd.ap_aporte_detalle_id||
                                            '{$_s}monto:'||apd.monto||
                                            '{$_s}moneda:'||cm.nombre||
                                            '{$_s}fecha:'||apd.fecha||
                                            '{$_s}tipo:'||apt.nombre||
                                            '{$_s}rol_socio:'||rst.nombre,';*')")
                ))
             ->join(
                array('cm' => 'cont_moneda'), 
                'apd.cont_moneda_id = cm.cont_moneda_id',
                array(),
                ZFSelect::JOIN_LEFT
               )
             ->join(
                array('apt' => 'ap_aporte_tipo'), 
                'apd.ap_aporte_tipo_id = apt.ap_aporte_tipo_id',
                array(),
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
                array(),
                ZFSelect::JOIN_LEFT
               )                                        
             ->group('apd.ap_aporte_detalle_id');
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("apd.org_parte_rol_cargador_id = $id");
        }
    }
}