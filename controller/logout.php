<?php
session_start();

// Eliminar todas las variables de sesión
session_unset();
session_destroy();

// Regenerar el ID de sesión
session_regenerate_id(true);

// Eliminar cookies de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Evitar que el navegador guarde la caché de la página
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: 0"); // Prohibir caché

// Redirigir al login
header("Location: ../login.php");
exit();
