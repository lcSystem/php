<?php
session_start();
require_once '../config/paths.php';
require_once '../models/userModel.php';

header('Content-Type: application/json'); // <-- importante para AJAX

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => true,
        'redirect' => DASHBOARD_URL
    ]);
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$response = ['success' => false, 'tipo' => 'error', 'titulo' => 'Error', 'mensaje' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $response['mensaje'] = "Por favor, ingresa tanto el nombre de usuario como la contraseña.";
    } else {
        $usuario = new Usuario();
        $user = $usuario->login($username, $password);

        if ($user) {
            if ($user['estado'] !== 'activo') {
                $response['mensaje'] = "El usuario no está activo.";
            } elseif (!password_verify($password, $user['password'])) {
             $usuario->incrementarIntento($user['id']);

            $userActualizado = $usuario->login($username, $password);
                if ($userActualizado['intentos_fallidos'] >= 3) {
                    $usuario->inactivarUsuario($user['id']);
                    $response['mensaje'] = "Usuario bloqueado por 3 intentos fallidos.";
                } else {
                    $restantes = 3 - $userActualizado['intentos_fallidos'];
                    $response['mensaje'] = "Contraseña incorrecta. Intentos restantes: $restantes.";
                }
                $response['mensaje'] = "La contraseña no coincide.";
            } else {
                // Login correcto
                 $usuario->resetearIntentos($user['id']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['user_rol'] = $user['rol']; 

                $response['success'] = true;
                $response['redirect'] = DASHBOARD_URL;
            }
        } else {
            $response['mensaje'] = "Usuario o contraseña incorrectos.";
        }
    }
}

// Devuelve la respuesta en JSON
echo json_encode($response);
exit();
