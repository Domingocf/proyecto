<?php
include_once("../MODELO/bd.php");
include_once("../MODELO/comentarios.php");


function crearComentario($descripcion,$usuario,$cancion,$parent_id) { 
    Comentario::crearComentario($descripcion,$usuario,$cancion,$parent_id);
}
function listarComentarios($idCancion) {
    Comentario::listarComentarios($idCancion);
}
function cargarComentarios($idCancion) {
    return Comentario::cargarComentarios($idCancion);
}

function reportar($comentario,$usuario){
    Comentario::anadirReporte($comentario,$usuario);
}
?>