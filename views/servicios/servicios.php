<?php
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
    'toggle' => 'cambiarEstadoServicio'
];

$addButton = [
    'label' => 'Agregar Servicio',
    'onClick' => 'abrirModalAgregarServicio()',
    'class' => 'btn-gold'
];

renderTable('servicio', 'Servicios Registrados', $columns, $servicios, $actions, $addButton);
?>

<!-- modal para gestionar servicios -->

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
 const estados = ["activo", "inactivo"];
  const SERVICIO_CONTROLLER_URL =  "<?= SERVICIO_CONTROLLER_URL ?>";
  const camposServicio = [
      { nombre: "nombre", etiqueta: "nombre", tipo: "text" },
      { nombre: "duracion_minutos", etiqueta: "duracion minutos", tipo: "number" },
      { nombre: "precio", etiqueta: "precio", tipo: "number" },
      { nombre: "descripcion", etiqueta: "descripcion", tipo: "textarea" },
      { nombre: "estado", etiqueta: "Estado", tipo: "select", 
                 opciones: estados.map(e => ({ value: e, text: e }))}

    ];


function abrirModalAgregarServicio() {
  abrir(camposServicio, "", "Servicio", (data) => {
    guardarServicio(data);
    
  });
}

function abrirModalEditarServicio(id, datosServicio) {
    abrir(camposServicio, datosServicio, "Servicio", (dataActualizada) => {
        actualizarServicio(id, dataActualizada);
    });
}


function guardarServicio(data) {
    const datos = {
        nombre: data.nombre,
        descripcion: data.descripcion,
        duracion_minutos: parseInt(data.duracion_minutos) || 60,
        estado: 'activo',
        precio: data.precio
    };

    guardarRegistro(`${SERVICIO_CONTROLLER_URL}?action=crearservicio`, datos, 'servicio', (response) => {
        servicios.push(response.servicio);
        refrescarTabla('servicio'); 
    });
}

function eliminarServicio(id) {
    eliminarRegistro(`${SERVICIO_CONTROLLER_URL}?action=eliminarServicio`, id, 'servicio', () => {
        refrescarTabla('servicio');
    });
}


function actualizarServicio(id, data) {
    actualizarRegistro(`${SERVICIO_CONTROLLER_URL}?action=actualizarServicio`, 
        { id, ...data }, 
        'servicio', 
        (response) => {
            refrescarTabla('servicio');
        }
    );
}

function cambiarEstadoServicio(id, estadoActual) {
    cambiarEstado(`${SERVICIO_CONTROLLER_URL}?action=cambiarEstado`, id, estadoActual, 'servicio', () => {
        refrescarTabla('servicio');
    });
}

</script>

