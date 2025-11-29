<?php
require_once '../MODELO/bd.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Esto carga PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Pago
{

    public static function guardar(string $usuario, string $tipo, ?string $tarjeta_num = null, ?string $tarjeta_exp = null, ?string $email = null): bool
    {
        $con = new bd();
        $conexion = $con->Conectar();

        $stmt = $conexion->prepare("
            INSERT INTO formadepago (usuario, tipo, tarjeta_num, tarjeta_exp, paypal_email)
            VALUES (:usuario, :tipo, :tarjeta_num, :tarjeta_exp, :email)
        ");
        return $stmt->execute([
            ':usuario' => $usuario,
            ':tipo' => $tipo,
            ':tarjeta_num' => $tarjeta_num,
            ':tarjeta_exp' => $tarjeta_exp,
            ':email' => $email
        ]);
    }

    public function enviarEmailConfirmacion(string $usuario, string $tipo, string $email): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'domingocf2000@gmail.com';
            $mail->Password = 'xaoz ekyh unud ytcv';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('domingocf2000@gmail.com', 'MusicConnect');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de pago - MusicConnect';
            $mail->Body = $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Pago</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin: 0 auto; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
        <tr>
            <td style="background-color:#007bff; padding:30px; text-align:center; color:#ffffff;">
                <h1 style="margin:0; font-size:28px;">🎵 MusicConnect</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:30px; text-align:center;">
                <h2 style="color:#333333; font-size:24px;">¡Pago Confirmado!</h2>
                <p style="color:#555555; font-size:16px; line-height:24px;">
                    Hola <strong>'.$usuario.'</strong>,<br><br>
                    Tu pago mediante <strong>'.$tipo.'</strong> ha sido registrado correctamente.
                </p>
                <a href="https://musicconnect.com/login" target="_blank" style="display:inline-block; margin-top:20px; padding:12px 25px; font-size:16px; color:#ffffff; background-color:#28a745; text-decoration:none; border-radius:5px;">Accede a tu cuenta</a>
            </td>
        </tr>
        <tr>
            <td style="background-color:#f8f9fa; padding:20px; text-align:center; font-size:12px; color:#888888;">
                © 2025 MusicConnect. Todos los derechos reservados.<br>
                No respondas a este correo, es automático.
            </td>
        </tr>
    </table>
</body>
</html>
';

            $mail->send();
            echo"<h2>pago efectuado con exito</h2>";
            return true;
        } catch (Exception $e) {
            error_log("Error enviando email: {$mail->ErrorInfo}");
            return false;
        }
    }
}
