<?php
namespace Org\Profesion\Collection;
function crearElementos($datosDeElementos,$factory){
	return array_map(
		function($datoDeElemento) use($factory){
			return $factory($datoDeElemento);
		}, 
	    $datosDeElementos
	);
}

function editarElementos($datosParaElementos,$elementos,$editar,$get = null){
	return array_map(
		function($datosParaElemento)use($elementos,$editar,$get){
			$elemento = $get($datosParaElemento,$elementos);
			return $editar($elemento,$datosParaElemento);
		},
		$datosParaElementos
	);
}

function getElementos($elementos,$ids,$getElementoId = null)
{
	if(!$getElementoId){
		$getElementoId = crearGetElementoIdFunction();
	}
	return array_filter($elementos,function($elemento)use($ids,$getElementoId){
		if(in_array($getElementoId($elemento), $ids)){
			return true;
		}
		return false;
	});
}

function removerElementos($coleccion,$elementos,$getElementoId){
	return array_udiff(
			$coleccion, $elementos,
			function($a,$b) use($getElementoId){
				if($getElementoId($a) == $getElementoId($b)){
					return 0;
				}
				return -1;
			}
	);
}

function crearGetElementoFunction($idIndex,$elementos){
	return function($datosDeElemento,$elementos) use($idIndex){
		$id = $datosDeElemento[$idIndex];
		$elementos = getElementos($elementos, array($id));
		return current($elementos);
	};
}

function crearGetElementoIdFunction($method = "getId"){
	return function($elemento) use($method){
		return $elemento->{$method}();
	};
}