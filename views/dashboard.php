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
                  include 'formulario/formulario.php';
                  break;
              case 'citas':
                  include 'citas/citas.php';
                  break;
              case 'indicator':
                  require_once '../views/indicador.php';  
                  break;
              case 'package':
                  echo "<div class='card'><h3>Gestión de Packages</h3><p>Administra paquetes y dependencias.</p></div>";
                  break;
              case 'config':
                  include 'config/config.php';
                  break;
             case 'perfil':
                require_once  '../controller/perfil/perfilController.php';
                $ctrl = new PerfilController();
                $usuario = $ctrl->mostrarPerfil($ctrl->getSessionUserId());
                include 'perfil/perfil.php';
                break;
             case 'users':
    // Verificar si el usuario es admin
    if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
        echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
        break;
    }
    
    require_once '../controller/userController.php';
    $controller = new UserController();
    $controller->mostrarUsuarios(); 
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