<?php
session_start();

require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../config/paths.php';

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
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/styleUser.css">
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/perfil.css">
  <!-- Flatpickr CSS -->
<link rel="stylesheet" href="assets/css/flatpickr.min.css">
<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/css/all.min.css">
<style type="text/css">
  
#modalEditar {
    position: fixed;
    top: 50%;
    left: 0;
    width: 100%;
    height: auto; /* que se ajuste al contenido */
    background: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    overflow-y: auto;
    padding: 20px;
    font-family: 'Poppins', sans-serif;
    transform: translateY(-50%);
}
/* Contenido modal */
#modalEditar .modal-content {
    background: #fff;
    border-radius: 18px;
    padding: 35px 30px;
    max-width: 760px;
    width: 100%;
    box-shadow: 0 12px 28px rgba(0,0,0,0.2);
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    position: relative;
    animation: fadeIn 0.35s ease-in-out;
    max-height: 90vh; /* máximo 90% de la pantalla */
    overflow-y: auto;
}

/* Animación */
@keyframes fadeIn {
    from {opacity:0; transform: translateY(-25px);}
    to {opacity:1; transform: translateY(0);}
}

/* Botón cerrar */
#modalEditar .close {
    position: absolute;
    top: 18px;
    right: 20px;
    font-size: 28px;
    cursor: pointer;
    color: #d4a017;
    transition: color 0.2s;
}
#modalEditar .close:hover {
    color: #ffd24d;
}

/* Encabezado */
#modalEditar h2 {
    text-align: center;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
}

/* Formulario */
#formEditarUsuario {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 15px;
}
#formEditarUsuario .full { grid-column: 1 / -1; }

#formEditarUsuario label {
    font-weight: 600;
    font-size: 13px;
    color: #333;
    display: block;
    margin-bottom: 6px;
}

/* Inputs y Select */
#formEditarUsuario input[type="text"],
#formEditarUsuario input[type="email"],
#formEditarUsuario input[type="date"],
#formEditarUsuario select {
    width: 100%;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1px solid #ddd;
    background: #fdfdfd;
    box-sizing: border-box;
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.05);
    font-size: 0.95rem;
    transition: all 0.25s;
}
#formEditarUsuario input:focus,
#formEditarUsuario select:focus {
    outline: none;
    border-color: #d4a017;
    box-shadow: 0 0 10px rgba(212,175,55,0.35);
}

/* Select con flecha personalizada */
#formEditarUsuario select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #fdfdfd url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12'><polygon points='0,0 12,0 6,6' fill='%23666'/></svg>") no-repeat right 16px center;
    background-size: 12px;
    cursor: pointer;
}

/* Botón guardar */
#formEditarUsuario .btn-save {
    grid-column: 1 / -1;
    padding: 14px 0;
    border-radius: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg,#FFD24D,#D4A017);
    color: #111;
    box-shadow: 0 8px 20px rgba(212,175,55,0.25);
    transition: transform .2s ease, box-shadow .2s ease;
}
#formEditarUsuario .btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(212,175,55,0.35);
}

/* Nota / ayuda */
#formEditarUsuario .note {
    font-size: 12px;
    color: #666;
    margin-top: 6px;
}

/* Responsive */
@media (max-width: 820px) {
    #formEditarUsuario {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    #modalEditar {
        padding: 10px;
    }
    #modalEditar .modal-content {
        padding: 20px 15px;
    }
}
</style>
</head>
<body>
<header>
        <!-- Avatar + menú -->
    <div class="user-menu">
      <img  src="<?= !empty($usuario['avatar']) ? IMG_UPLOADS_URL . '/' . htmlspecialchars($usuario['avatar']) : ASSETS_URL . '/img/logof.png' ?>"  
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