.<?php session_start(); 
 require_once __DIR__ . '/config/paths.php';?>

<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estefany - Beauty</title>
  <link href="assets/css/css2.css" rel="stylesheet">
  <link href="assets/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/modal-log.css">
</head>
<body>
  <div class="container">
    <!-- LOGIN -->
    <div id="loginForm" class="form">
      <img src="assets/img/logof.png" alt="Logo">
      <h2>Bienvenido</h2>
      <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
     <form id="loginUserPassword">
    <div class="input-field">
        <input type="text" name="username" placeholder="Usuario" required>
        <i class="fa fa-user"></i>
    </div>
    <div class="input-field">
        <input type="password" name="password" placeholder="Contraseña" required  autocomplete="off" >
         <i class="fa-solid fa-eye-slash toggle-password" data-target="loginPassword" aria-hidden="true"></i> 
    </div>
    <button type="submit" class="btn">Iniciar Sesión</button>
</form>

      <button onclick="showRegister()" class="btn btn-outline">Crear Cuenta</button>
<div class="forgot-password">
  <a href="#" onclick="showForgotPassword()">¿Olvidaste tu contraseña?</a>
</div>
      <div class="social-media">
  <p>Síguenos en</p>
  <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
  <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
  <a href="https://twitter.com" target="_blank"><i class="fab fa-x-twitter"></i></a>
  <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
</div>
    </div>

    <!-- REGISTRO -->
    <div id="registerForm" class="form hidden">
      <img src="assets/img/logof.png" alt="Logo">
      <h2>Crear Cuenta</h2>
      <form id="formRegister" >
        <div class="input-field"><input type="text" name="username" placeholder="Alias" required><i class="fa fa-user"></i></div>
        <div class="input-field"><input type="text" name="nombreCompleto" placeholder="Nombre completo" required><i class="fa fa-user"></i></div>
        <div class="input-field"><input type="text" name="direccion" placeholder="Dirección" required><i class="fa fa-map-marker-alt"></i></div>
        <div class="input-field"><input type="text" name="telefono" placeholder="Teléfono" required><i class="fa fa-phone"></i></div>
        <div class="input-field"><input type="text" name="celular" placeholder="Celular"><i class="fa fa-mobile-alt"></i></div>
        <div class="input-field"><input type="email" name="email" placeholder="Correo electrónico" required><i class="fa fa-envelope"></i></div>
        <div class="input-field"><input type="password" name="password" placeholder="Contraseña" required  autocomplete="off"><i class="fa fa-lock"></i></div>
        <div class="input-field"><input type="number" name="edad" placeholder="Edad" max="99"><i class="fa fa-calendar"></i></div>
        <div class="gender-options">
          <input type="radio" id="femenino" name="sexo" value="F" required checked>
          <label for="femenino">Femenino</label>
          <input type="radio" id="masculino" name="sexo" value="M">
          <label for="masculino">Masculino</label>
          <input type="radio" id="otro" name="sexo" value="O">
          <label for="otro">Otro</label>
        </div>
        <button type="submit" class="btn">Registrarse</button>
      </form>
      <a class="toggle-link" onclick="showLogin()">¿Ya tienes cuenta? Inicia sesión</a>
    </div>

    <!-- Modal de recuperación -->
<!-- Modal de recuperación responsive -->
<div id="forgotPasswordModal" class="modal hidden">
  <div class="modal-content">
    <form id="forgotPasswordForm">
      <div class="modal-header">
        <h2>Recuperar Contraseña</h2>
        <span class="close" onclick="closeForgotPassword()">&times;</span>
      </div>
      <p>Ingresa tu correo electrónico para recibir un enlace de restablecimiento:</p>
      <div class="input-field">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <i class="fa fa-envelope"></i>
      </div>
      <button type="submit" class="btn">Enviar enlace</button>
    </form>
  </div>
</div>


<script src="assets/js/jquery-3.6.4.min.js"></script>
  <script src="assets/js/sweetalert2@11.js"></script>
  <script src="<?php echo LOGIN_JS; ?>"></script>
  <?php if (isset($_SESSION['alerta'])): ?>

  <?php unset($_SESSION['alerta']); endif; ?>


</body>
</html>