<?php
require_once '../../models/userModel.php';  

header('Content-Type: application/json'); 

$response = [
    "success" => false,
    "tipo" => "error",
    "titulo" => "Error",
    "mensaje" => "Ocurrió un error inesperado",
    "redirect" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $nombreCompleto = $_POST['nombreCompleto'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $edad = $_POST['edad'] ?? '';
    $sexo = $_POST['sexo'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $response["mensaje"] = "Todos los campos obligatorios deben llenarse.";
        $response["tipo"] = "warning";
        $response["titulo"] = "Campos vacíos";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["mensaje"] = "Correo electrónico no válido.";
        $response["tipo"] = "warning";
        $response["titulo"] = "Error de validación";
    } else {
        $usuario = new Usuario();
        $existingUser = $usuario->verificarExistencia($username, $email);

        if ($existingUser) {
            $response["mensaje"] = "El usuario o correo ya existen.";
            $response["tipo"] = "warning";
            $response["titulo"] = "Usuario existente";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $isRegistered = $usuario->registrar($username, $email, $passwordHash, $nombreCompleto, $telefono, $direccion, $edad, $sexo);

            if ($isRegistered) {
                $response["success"] = true;
                $response["tipo"] = "success";
                $response["titulo"] = "Registrado";
                $response["mensaje"] = "Registro exitoso. Redirigiendo al login...";
                $response["redirect"] = "login.php";
            } else {
                $response["mensaje"] = "No se pudo registrar el usuario. Intenta nuevamente.";
                $response["tipo"] = "error";
                $response["titulo"] = "Error";
            }
        }
    }
}

echo json_encode($response);
exit();
?>
