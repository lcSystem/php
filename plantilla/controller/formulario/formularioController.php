
<?php
session_start();

// Evitar que el navegador guarde caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Formulario Futurista</title>
  <style>
    /* Estilos globales */
    body {
      background-color: #121212;
      font-family: 'Arial', sans-serif;
      color: #0ff;
      margin: 0;
      padding: 0;
    }

    /* Contenedor principal */
    .container {
      margin-top: 50px;
      padding: 30px;
      border-radius: 10px;
      background-color: #1c1c1c;
      box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }

    h1 {
      color: #0ff;
      text-align: center;
      font-size: 2.5em;
      text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
    }

    /* Estilo de los campos de formulario */
    .form-control, .form-control-file, .form-check-input {
      background-color: #222;
      color: #0ff;
      border: 2px solid #0ff;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }

    /* Efectos al enfocar los campos */
    .form-control:focus, .form-control-file:focus, .form-check-input:focus {
      border-color: #00ff00;
      background-color: #333;
      outline: none;
    }

    /* Botones */
    .btn-primary {
      background-color: #0ff;
      border: none;
      padding: 15px;
      font-size: 1.2em;
      border-radius: 10px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #00ff00;
    }

    /* Estilos para los labels */
    label {
      font-size: 1.1em;
      color: #bbb;
    }

    /* Estilos adicionales para el radio button */
    .form-check-label {
      color: #bbb;
    }

    /* Contenedores de fila */
    .form-row {
      margin-bottom: 20px;
    }

    /* Animaciones de carga */
    .fadeIn {
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

  </style>
</head>
<body>

<div class="container fadeIn">
  <h1>AUTO-DOCUMENTADOR</h1>
  <form id="formulario">
    <!-- Anexar imágenes -->
    <div class="form-group">
      <label for="imagenes">Anexar imágenes documentadas (.doc, .odt):</label>
      <input type="file" class="form-control-file" id="imagenes" accept=".doc, .odt" multiple>
    </div>

    <!-- Fila con varios campos -->
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="caso">Caso (5 dígitos):</label>
        <input type="text" class="form-control" id="caso" maxlength="5" required>
      </div>
      <div class="form-group col-md-4">
        <label for="proyecto">Proyecto:</label>
        <select class="form-control" id="proyecto" required>
          <option value="iceberg-niif">Iceberg NIIF</option>
          <option value="iceberg-fe">Iceberg FE</option>
          <option value="iceberg-ep">Iceberg EP</option>
          <option value="iceberg-cs">Iceberg CS</option>
          <option value="icebergrs">Icebergrs</option>
          <option value="iceberg-pf">Iceberg PF</option>
          <option value="iceberg-gp">Iceberg GP</option>
          <option value="iceberg">Iceberg</option>
          <option value="iceberg-pe">Iceberg PE</option>
          <option value="icebergzero">Iceberg Zero</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="v_d">V/D:</label>
        <select class="form-control" id="v_d" required>
          <option value="iceberg-niif">Verificación</option>
          <option value="iceberg-fe">Desarrollo</option>
        </select>
      </div>
    </div>

    <!-- Fila adicional con campos -->
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="caso_soporte">Caso Soporte (5 dígitos, puede ser nulo):</label>
        <input type="text" class="form-control" id="caso_soporte" maxlength="5">
      </div>
      <div class="form-group col-md-4">
        <label for="cliente">Cliente:</label>
        <select class="form-control" id="cliente" required>
          <option value="konrad">Konrad</option>
          <option value="unimariana">unimariana</option>
          <option value="utb">utb</option>
          <option value="usc">usc</option>
          <option value="usb">usb</option>
          <option value="unibague">unibague</option>
          <option value="ugc">ugc</option>
          <option value="libertadores">libertadores</option>
          <option value="ibero">ibero</option>
          <option value="uao">uao</option>
          <option value="cur">cur</option>
          <option value="corhuila">corhuila</option>
          <option value="cesa">cesa</option>
          <option value="catolica">catolica</option>
          <option value="fusm">fusm</option>
          <option value="udi">udi</option>
          <option value="ucn">ucn</option>
          <option value="umc">umc</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="dos_caracteres">Dos Caracteres:</label>
        <input type="text" class="form-control" id="dos_caracteres" style="text-transform: uppercase;" maxlength="2" required>
      </div>
    </div>

    <!-- Descripción -->
    <div class="form-group">
      <label for="descripcion">Descripción del caso (20 caracteres):</label>
      <textarea class="form-control" id="descripcion" rows="3" maxlength="20" required></textarea>
    </div>

    <!-- Objetos de BD -->
    <div class="form-group">
      <label>Objetos de BD:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="objetos_bd" id="si_objetos_bd" value="si" required>
        <label class="form-check-label" for="si_objetos_bd">Sí</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="objetos_bd" checked id="no_objetos_bd" value="no" required>
        <label class="form-check-label" for="no_objetos_bd">No</label>
      </div>
    </div>

    <!-- Adjuntar carpeta SQL -->
    <div class="form-group">
      <label for="sql_carpeta">Anexar carpeta SQL:</label>
      <input type="file" class="form-control-file" id="sql_carpeta" directory webkitdirectory>
    </div>

    <!-- WAR -->
    <div class="form-group">
      <label>WAR:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="war" id="si_war" value="si" required>
        <label class="form-check-label" for="si_war">Sí</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="war" id="no_war" checked value="no" required>
        <label class="form-check-label" for="no_war">No</label>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

