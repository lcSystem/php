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

 const SERVICIO_CONTROLLER_URL =  "<?= SERVICIO_CONTROLLER_URL ?>";
 var estados = ["activo", "inactivo"];


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

function refrescarTabla(entidad) {
    const table = document.getElementById(entidad);
    if (!table) return;

    // Limpiar tbody
    const tbody = table.querySelector("tbody");
    tbody.innerHTML = "";

    // Agregar filas nuevas
    servicios.forEach(row => {
        const tr = document.createElement("tr");

        // Columnas
        <?php foreach ($columns as $key => $label): ?>
        const td<?= $key ?> = document.createElement("td");
        td<?= $key ?>.textContent = row["<?= $key ?>"] ?? "";
        tr.appendChild(td<?= $key ?>);
        <?php endforeach; ?>

        // Acciones
        const tdAcciones = document.createElement("td");
        tdAcciones.innerHTML = `
            <button class="btn-edit" onclick='abrirModalEditarServicio(${row.id}, ${JSON.stringify(row)})'>
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn-delete" onclick='eliminarServicio(${row.id})'>
                <i class="fas fa-trash-alt"></i>
            </button>
            <button class="btn-toggle" onclick='cambiarEstadoServicio(${row.id}, "${row.estado}")'>
                ${row.estado === "activo" ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'}
            </button>
        `;
        tr.appendChild(tdAcciones);

        tbody.appendChild(tr);
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

