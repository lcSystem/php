<?php
session_start();

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../models/userModel.php';

$usuarioModel = new Usuario();
$idUsuario = $_SESSION['user_id'] ?? 0;
$usuario = $usuarioModel->obtenerPorId($idUsuario) ?? [];

// Evitar caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Validar login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="LuigiTech: Soluciones tecnológicas modernas, dashboards interactivos y desarrollo web de última generación.">
<meta name="keywords" content="LuigiTech, tecnología, dashboards, desarrollo web, sistemas, hosting, Colombia">
<meta name="author" content="Luigi Cardenas">
  <title>Estefany - Beauty </title>
  <!-- Librería de íconos -->
  <link href="../assets/css/dashboard.css" rel="stylesheet">
   <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/citas.css">
  <link rel="stylesheet" href="<?php echo STYLEUSER_CSS; ?>">
  <link rel="stylesheet" href="<?php echo PERFIL_CSS; ?>">
  <!-- Flatpickr CSS -->
<link rel="stylesheet" href="<?php echo JQUERY_DATAT_CSS; ?>">
<link rel="stylesheet" href="<?php echo ALL_CSS; ?>">
<link rel="stylesheet" href="<?php echo MODALEDIT_CSS; ?>">
<link rel="stylesheet" href="<?php echo FLATPICKR_CSS; ?>">
<link rel="stylesheet" href="<?= NOTIFY_CSS ?>">
<link rel="stylesheet" href="<?php echo STYLEBUTTONS_CSS; ?>">


</head>
<body>
<header>
        <!-- Avatar + menú -->
    <div class="user-menu">
      <img  src="<?= !empty($usuario['avatar']) ? IMG_UPLOADS_URL . '/' . htmlspecialchars($usuario['avatar']) : LOGOF_PNG ?>"  
           alt="Avatar" class="avatar" onclick="toggleMenu()">
      <div id="dropdown" class="dropdown hidden">
        <a href="../controller/logout.php">Cerrar sesión</a>
         <a href="?page=perfil">Perfil</a>
      </div>
    </div>
<div class="user-info">
  <h1>Hola, <?= $_SESSION['username'] ?? 'Usuario' ?></h1>
  <p>Ubicación: Colombia</p>
</div>

  <div class="icon"><i class="fa-solid fa-bell"></i></div>

</header>