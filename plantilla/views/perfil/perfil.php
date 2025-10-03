<?php
require_once __DIR__ . '/../../config/paths.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
   <meta name="description" content="LuigiTech: Soluciones tecnológicas modernas, dashboards interactivos y desarrollo web de última generación.">
<meta name="keywords" content="LuigiTech, tecnología, dashboards, desarrollo web, sistemas, hosting, Colombia">
<meta name="author" content="Luigi Cardenas">
  <title>Mi Perfil</title>
</head>
<body>
<div class="perfil-wrap">
  <div class="perfil-card">
    <!-- columna avatar -->
    <div class="perfil-avatar">
     <img id="avatarPreview" 
           src="<?= !empty($usuario['avatar']) ? IMG_UPLOADS_URL . '/' . htmlspecialchars($usuario['avatar']) : ASSETS_URL . '/img/logof.png' ?>" 
           alt="Avatar">
      <div class="small">Usuario: <strong><?= htmlspecialchars($usuario['username'] ?? '') ?></strong></div>
        <form id="fotoForm" action="<?= PERFIL_CONTROLLER ?>" method="POST" enctype="multipart/form-data" class="full">
        <input type="file" name="foto" id="fotoFile" accept="image/*">
        <div class="note">Elige una imagen JPG/PNG. Máx 2MB (si no subes, no se cambia).</div>
        <div style="margin-top:8px;">
          <button type="submit" name="actualizarFoto" class="btn-save" style="padding:8px 12px; font-size:14px;">Actualizar Foto</button>
          <?php if (!empty($usuario['avatar'])): ?>
            <button type="submit" name="eliminarFoto" value="1" formaction="<?= PERFIL_CONTROLLER ?>" class="btn-danger">Eliminar Foto</button>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- columna form datos -->
    <div>
      <form id="datosForm" action="<?= PERFIL_CONTROLLER ?>" method="POST" class="perfil-form">
        <input type="hidden" name="id" value="<?= intval($usuario['id'] ?? 0) ?>">

        <div>
          <label>Username</label>
          <input class="readonly" type="text" value="<?= htmlspecialchars($usuario['username'] ?? '') ?>" readonly>
        </div>

        <div class="full">
          <label>Nombre completo</label>
          <input type="text" name="nombre_completo" value="<?= htmlspecialchars($usuario['nombre_completo'] ?? '') ?>" required>
        </div>

        <div>
          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
        </div>

        <div>
          <label>Teléfono</label>
          <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
        </div>

        <div class="full">
          <label>Dirección</label>
          <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion'] ?? '') ?>">
        </div>

        <div>
          <label>Edad</label>
          <input type="number" min="0" name="edad" value="<?= htmlspecialchars($usuario['edad'] ?? '') ?>">
        </div>

        <div>
          <label>Sexo</label>
          <select name="sexo">
            <option value="M" <?= (isset($usuario['sexo']) && $usuario['sexo']==='M') ? 'selected' : '' ?>>Masculino</option>
            <option value="F" <?= (isset($usuario['sexo']) && $usuario['sexo']==='F') ? 'selected' : '' ?>>Femenino</option>
            <option value="O" <?= (isset($usuario['sexo']) && $usuario['sexo']==='O') ? 'selected' : '' ?>>Otro</option>
          </select>
        </div>

        <div class="full">
          <label>Nueva contraseña <small>(opcional)</small></label>
          <input type="password" id="new_password" name="new_password" placeholder="Dejar en blanco = sin cambio">
        </div>

        <div>
          <label>Confirmar contraseña</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Repite la nueva contraseña">
        </div>

        <!-- Si quieres mostrar otros campos de tu tabla añade aquí (sin 'estado' según pediste). -->
        <!-- Por ejemplo fecha_registro readonly si la tuvieras: -->
        <?php if (!empty($usuario['fecha_registro'])): ?>
          <div class="full">
            <label>Fecha de registro</label>
            <input class="readonly" type="text" value="<?= htmlspecialchars($usuario['fecha_registro']) ?>" readonly>
          </div>
        <?php endif; ?>

        <div class="btn-group">
          <button type="submit" name="actualizarDatos" class="btn-save">Guardar cambios</button>
          <button type="button" onclick="location.href='../views/dashboard.php'" class="btn-danger">Volver</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Preview imagen seleccionada
  document.getElementById('fotoFile').addEventListener('change', function(e){
    const file = e.target.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = function(ev){ document.getElementById('avatarPreview').src = ev.target.result; };
    reader.readAsDataURL(file);
  });

  // Verificar contraseñas antes de enviar datos
  document.getElementById('datosForm').addEventListener('submit', function(e){
    const p1 = document.getElementById('new_password').value;
    const p2 = document.getElementById('confirm_password').value;
    if (p1 || p2) {
      if (p1.length < 6) { alert('La nueva contraseña debe tener al menos 6 caracteres.'); e.preventDefault(); return; }
      if (p1 !== p2) { alert('Las contraseñas no coinciden.'); e.preventDefault(); return; }
    }
    // si todo ok, se envía el formulario
  });
</script>
</body>
</html>