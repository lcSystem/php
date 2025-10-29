<?php 
 include 'header.php'  ?> 
<div class="container">
    <!-- Search -->
    <div class="search-box">
      <input type="text" id="mi-buscador" placeholder="Buscar en el sistema...">
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
                    require_once  SERVICIO_CONTROLLER;
                  break;

              case 'citas':
                  require_once  CITAS_CONTROLLER;
                  break;

             case 'users':
                  require_once USER_CONTROLLER;
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