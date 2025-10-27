<?php
require_once __DIR__ . '/../config/paths.php';
?>
  <!-- Bottom Nav -->
  <div class="bottom-nav">
    <button class="<?php echo !isset($_GET['page']) ? 'active' : ''; ?>" onclick="window.location='dashboard.php'">
      <i class="fa-solid fa-house"></i><span>Inicio</span>
    </button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'formulario' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=formulario'">
      <i class="fa-solid fa-file-alt"></i><span>Formularios</span>
    </button>
        <button class="<?php echo ($_GET['page'] ?? '') === 'servicios' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=servicios'"
           <?php echo (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] !== 'admin') ? 'style="display:none;"' : ''; ?>>
      <i class="fa-solid fa-scissors"></i><span>Servicios</span>
    </button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'citas' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=citas'">
      <i class="fa-solid fa-clock"></i><span>Agenda</span>
    </button>
   <button class="<?php echo ($_GET['page'] ?? '') === 'users' ? 'active' : ''; ?>"  onclick="window.location='dashboard.php?page=users'"
        <?php echo (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] !== 'admin') ? 'style="display:none;"' : ''; ?>>
    <i class="fa-solid fa-user"></i><span>Usuarios</span>
  </button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'app' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=config'">
      <i class="fa-solid fa-gear"></i><span>Config</span>
    </button>
  </div>
</body>

 
<script src="<?php echo JQUERY_JS; ?>"></script>
<script src="<?php echo FLATPICKR_JS; ?>"></script>
<script src="<?php echo BUNDLET_JS; ?>"></script>
<script src="<?php echo JQUERY_DT_JS; ?>"></script>
<script src="<?php echo DATATABLE_JS; ?>"></script>
<script src="<?php echo UT_UTILIDADES_JS; ?>"></script>
<script src="<?php echo NOTIFY_JS ?>"></script> 
<script src="<?php echo T_MENU_JS ?>"></script> 
<script src="<?php echo CP_MODALS ?>"></script> 


</html>