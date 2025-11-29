<?php
require_once '../MODELO/Pago.php';
require_once '../MODELO/Usuario.php';

function guardarPago($usuario, $tipo, $tarjeta_num = null, $tarjeta_exp = null, $email = null) {
    // Crear instancia de Pago con la conexión PDO
    $pago = new Pago();
    $id_usuario=Usuario::obteneridUsuario($usuario);
    // Guardar el pago en la base de datos
    $exito = $pago->guardar($id_usuario, $tipo, $tarjeta_num, $tarjeta_exp, $email);

    if ($exito) {
        // Enviar email de confirmación
        $pago->enviarEmailConfirmacion($usuario, $tipo,$email);
        return true;
    } else {
        return false;
    }
}
