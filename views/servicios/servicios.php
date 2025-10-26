<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/paths.php';
include_once CP_TABLE; 

$columns = [
    'id' => 'ID',
    'nombre' => 'Nombre',
    'descripcion' => 'Descripción',
    'duracion_minutos' => 'Duración',
    'precio' => 'Precio'
];

$actions = [
    'editar' => 'abrirModalEditarServicio',
    'eliminar' => 'eliminarServicio',
    'toggle' => 'toggleServicio'
];

$addButton = [
    'label' => 'Agregar Servicio',
    'onClick' => 'abrirModalAgregarServicio()',
    'class' => 'btn-gold'
];

renderTable('servicio', 'Servicios Registrados', $columns, $servicios, $actions, $addButton);
?>

<!-- modal para editar servicios -->

<template id="templateComponent-modal">
  <div class="modal"  style="display:none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="modal-title">Editar</h2>
      <form class="form-container"></form>
    </div>
  </div>
  </template>

  <script type="text/javascript">
const servicios = <?= json_encode($servicios, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  const camposCita = [
      { nombre: "id", etiqueta: "ID", tipo: "text"},
      { nombre: "nombre", etiqueta: "nombre", tipo: "text" },
      { nombre: "duracion_minutos", etiqueta: "duracion_minutos", tipo: "time" },
      { nombre: "descripcion", etiqueta: "descripcion", tipo: "textarea" }

    ];

  const valores = {
    id: 1,
    cliente: usuarioActual ? usuarioActual.id : "",
    fecha: fechaActual,
    hora: horaActual,
    servicio: 1,
    observaciones: ""
  };


function abrirModalAgregarServicio() {
  abrir(camposCita, "", "Servicio", (data) => {
    guardarServicio(data)

  });
}
</script>

<script src="<?php echo JQUERY_JS; ?>"></script>
 <script src="<?php echo SERVICIOS_JS ?>"></script>