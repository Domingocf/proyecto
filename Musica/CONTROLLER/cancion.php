<?php
	require_once '../MODELO/bd.php';
	require_once '../MODELO/cancion.php';

	function listarCanciones($pagina,$lista) {
    cancion::listarCanciones($pagina,12,$lista);
	
}
function cargarCancionesLista($listaId,$usuario) {
	return cancion::cargarCancionesLista($listaId,$usuario);
}
	


?>