<?php
// Configuración de la base de datos
define('DB_SERVER', 'localhost');  
define('DB_USERNAME', 'root');    
define('DB_PASSWORD', '');         
define('DB_DATABASE', 'DataCience');

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("ERROR: No se pudo conectar a la base de datos. " . $e->getMessage());
}

// Configuración de correo SMTP
define('MAIL_HOST', 'smtp.tuservidor.com');
define('MAIL_USER', 'tu@correo.com');
define('MAIL_PASS', 'tucontraseña');
define('MAIL_PORT', 587);
define('MAIL_FROM', 'tu@correo.com');
define('MAIL_FROM_NAME', 'Tu Sistema');
define('MAIL_SMTP_SECURE', 'tls'); // o 'ssl' 

define('F_HORARIO', '12');
define('F_FECHA', 'DD/MM/AA');

?>