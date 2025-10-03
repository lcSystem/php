<?php
session_start();
header('Content-Type: application/json');

// Usar rutas relativas
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer

$response = ['success' => false, 'titulo' => 'Error', 'mensaje' => 'Ocurrió un error', 'tipo' => 'error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $response['mensaje'] = 'Ingresa un correo válido';
        echo json_encode($response);
        exit;
    }

    $userModel = new UserModel();
    $user = $userModel->getUserByEmail($email);

    if (!$user) {
        $response['mensaje'] = 'No existe un usuario registrado con este correo';
        echo json_encode($response);
        exit;
    }

    $token = bin2hex(random_bytes(16));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $userModel->saveResetToken($user['id'], $token, $expiry);

    $resetLink = "https://{$_SERVER['HTTP_HOST']}" . BASE_URL . "/resetPassword.php?token=$token";

    // PHPMailer usando configuración de config.php
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Port       = MAIL_PORT;

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($email, $user['nombre_completo']);

        $mail->isHTML(true);
        $mail->Subject = 'Restablecer Contraseña';
        $mail->Body    = "
            <p>Hola {$user['nombre_completo']},</p>
            <p>Recibimos una solicitud para restablecer tu contraseña.</p>
            <p>Haz clic en el siguiente enlace para cambiar tu contraseña:</p>
            <a href='$resetLink'>$resetLink</a>
            <p>Este enlace expirará en 1 hora.</p>
            <p>Si no solicitaste este cambio, ignora este mensaje.</p>
        ";

        $mail->send();

        $response = [
            'success' => true,
            'titulo' => 'Correo enviado',
            'mensaje' => 'Revisa tu correo para restablecer tu contraseña',
            'tipo' => 'success'
        ];
    } catch (Exception $e) {
        $response['mensaje'] = 'No se pudo enviar el correo: ' . $mail->ErrorInfo;
    }
}

echo json_encode($response);
