<?php
session_start();

// Si ya hay sesión iniciada, redirige al dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
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
  <title>Welcome - Estefany Beauty</title>
  <link href="assets/css/welcome.css" rel="stylesheet">
</head>
<body>
  <!-- Fondo con burbujas -->
  <div class="background">
    <span></span><span></span>
    <span></span><span></span><span></span>
    <span></span><span></span>
    <span></span><span></span><span></span>
    <span></span><span></span>
    <span></span><span></span><span></span>
    <span></span><span></span>
    <span></span><span></span><span></span>
  </div>

  <!-- Contenedor de bienvenida -->
  <div class="welcome-container">
    <div class="image-section">
      <img src="assets/img/welcomeS.png" alt="Welcome" class="welcome-img">
    </div>
    <h2>Welcome</h2>
    <p>Get ready to shine and be your best self.</p>
    <div class="buttons">
      <!-- Mantener buttons para que no se pierda el estilo -->
      <button class="btn secondary" onclick="location.href='login.php?view=login'">Go</button>
    </div>
  </div>
</body>
</html>
