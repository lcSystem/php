<?php
session_start();

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/config.php';
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


  <link rel="icon" type="image/png" href="<?php echo LOGOF_PNG; ?>">
  <!-- Librería de íconos -->
  <link href="../assets/css/dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo JQUERY_DATAT_CSS; ?>">
   <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/citas.css">
  <link rel="stylesheet" href="<?php echo STYLEUSER_CSS; ?>">
  <link rel="stylesheet" href="<?php echo PERFIL_CSS; ?>">
  <!-- Flatpickr CSS -->
<link rel="stylesheet" href="<?php echo ALL_CSS; ?>">
<link rel="stylesheet" href="<?php echo MODALEDIT_CSS; ?>">
<link rel="stylesheet" href="<?php echo FLATPICKR_CSS; ?>">
<link rel="stylesheet" href="<?= NOTIFY_CSS ?>">
<link rel="stylesheet" href="<?php echo STYLEBUTTONS_CSS; ?>">
<link rel="stylesheet" href="<?php echo RESPONSIVEDT_CSS; ?>">
                <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>/evo-calendar.min.css">
                <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>/evo-calendar.orange-coral.min.css">
                <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>/evo-calendar.midnight-blue.min.css">
                <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>/evo-calendar.royal-navy.min.css">
                <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>/demo.css">
<script src="<?php echo JQUERY_JS; ?>"></script>
<script src="<?php echo FLATPICKR_JS; ?>"></script>
<script src="<?php echo BUNDLET_JS; ?>"></script>
<script src="<?php echo JQUERY_DT_JS; ?>"></script>
<script src="<?php echo DATATABLE_JS; ?>"></script>
<script src="<?php echo UT_UTILIDADES_JS; ?>"></script>
<script src="<?php echo NOTIFY_JS ?>"></script> 
<script src="<?php echo T_MENU_JS ?>"></script> 
<script src="<?php echo CP_MODALS ?>"></script> 
<script src="<?php echo HP_DOMPETICION; ?>"></script>
                <script src="<?php echo JS_URL; ?>/evo-calendar.min.js"></script>
                <script src="<?php echo JS_URL; ?>/demo.js"></script>

                
</head>
<body>
<header>
        <!-- Avatar + menú -->
    <div class="user-menu">
      <img  src="<?= !empty($usuario['avatar']) ? IMG_UPLOADS_URL . '/' . htmlspecialchars($usuario['avatar']) : LOGOF_PNG ?>"  
           alt="Avatar" class="avatar" onclick="toggleMenu()">
      <div id="dropdown" class="dropdown hidden">
         <a href="javascript:void(0);" onclick="confirmLogout()">Cerrar sesión</a>
         <a href="?page=perfil">Perfil</a>
      </div>
    </div>
<div class="user-info">
  <h1>Hola, <?= $_SESSION['username'] ?? 'Usuario' ?></h1>
  <p>Ubicación: Colombia</p>
</div>

  <div class="icon"><i class="fa-solid fa-bell"></i></div>

</header>
<script type="text/javascript">
 function confirmLogout() {
    const mensaje = "¿Seguro que quieres cerrar sesión?";
    showConfirmation(mensaje, () => {
        // Redirige al logout si confirma
        window.location.href = '../controller/logout.php';
    }, () => {
        showToast("Acción cancelada", "warning");
    });
}
</script>