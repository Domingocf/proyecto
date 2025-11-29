<?php
include_once '../MODELO/bd.php';
include_once '../MODELO/lista.php';

function obtenerListasUsuario($id_usuario) {
   return lista:: obtenerListasUsuario($id_usuario);
}

function anadeCancion($idLista, $idUsuario, $id_cancion) {
    lista:: anadeCancion($idLista, $idUsuario, $id_cancion);
}

function misListas($id_usuario) {
    return lista:: misListas($id_usuario);
}

function cargarMisListas(){
   lista::cargarMisListas();
}

function comparte($id_usuario, $idLista, $compartido){
   lista::comparte($id_usuario, $idLista, $compartido);
}

function obtenerListasCompartidas($id_usuario) {
    return lista::obtenerListasCompartidas($id_usuario);
}

function cargarCompartidas(){
   lista::cargarCompartidas();
}
?>