<?php 
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
                  
              case 'servicios':
               if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
                echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
                break;
                }
                 require_once  SERVICIO_CONTROLLER;
                  break;

              case 'citas':
                  require_once  CITAS_CONTROLLER;
                  break;

             case 'users':
                if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
                echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
                break;
                }
                require_once USER_CONTROLLER;
                $ctrl = new UserController();
                $ctrl->mostrarUsuarios(); 
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

<?php include CONST_JS  ?> 
<?php include 'footer.php'  ?> 