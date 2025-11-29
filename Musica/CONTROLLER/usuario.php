<?php
require_once("../MODELO/bd.php");
require_once("../MODELO/usuario.php");

function iniciarSesion($usuario, $password) {
    usuario::iniciarSesion($usuario, $password);
}
function registro($usuario, $email, $password) {
    usuario::registro($usuario, $email, $password);
}
function agregarFavorito($idCancion) {
    usuario::agregarFavorito($idCancion);
}
function obteneridUsuario($usuario) {
    return usuario::obteneridUsuario($usuario);
}
function getAllUsers($idUsuario) {
    return usuario::getAllUsers($idUsuario);
}
function obtenerUsername($id_lista) {
    return usuario::obtenerUsername($id_lista);
}
function imprimirsesion(){
    return usuario::imprimirSesion();
}




?>