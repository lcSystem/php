<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 include 'header.php'  ?> 
<div class="container">
    <!-- Search -->
    <div class="search-box">
      <input type="text" placeholder="Buscar en el sistema...">
    </div>

    <!-- Cards dinámicas -->
    <div class="content">
      <?php
      if (isset($_GET['page'])) {
          switch ($_GET['page']) {
              case 'formulario':
                  include FORMULARIO_VIEW;
                  break;

              case 'citas':
                  require_once  CITAS_CONTROLLER;
                  $controller = new citaController();
                  $controller -> index();
                  break;

             case 'users':
                if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
                echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
                break;
                }
                require_once USER_CONTROLLER;
                $controller = new UserController();
                $controller->mostrarUsuarios(); 
                break;

             case 'config':
                include CONFIG_VIEW;
                break;

             case 'perfil':
               require_once  PERFIL_CONTROLLER;
               $ctrl = new PerfilController();
               $usuario = $ctrl->mostrarPerfil($ctrl->getSessionUserId());
               include PERFIL_VIEW;
               break;

                default:
                  echo "<div class='card'><h3>Bienvenido</h3><p>Selecciona una opción para comenzar.</p></div>";
          }
      } else {
          echo "<div class='card'><h3>Bienvenido</h3><p>Selecciona una opción para comenzar.</p></div>";
      }
      ?>
    </div>
  </div>
<?php include 'footer.php'  ?> 