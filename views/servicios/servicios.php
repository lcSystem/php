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
 const SERVICIO_CONTROLLER_URL =  "<?= SERVICIO_CONTROLLER_URL ?>";
  const camposServicio = [
      { nombre: "nombre", etiqueta: "nombre", tipo: "text" },
      { nombre: "duracion_minutos", etiqueta: "duracion minutos", tipo: "number" },
      { nombre: "precio", etiqueta: "precio", tipo: "number" },
      { nombre: "descripcion", etiqueta: "descripcion", tipo: "textarea" },
      { nombre: "estado", etiqueta: "Estado", tipo: "select", 
        opciones: servicios.map(c => ({ value: c.estado, text: c.estado }))}

    ];

  const valores = {
    servicio: 1,
    estado: 'activo',
    descripcion: ""
  };


function abrirModalAgregarServicio() {
  abrir(camposServicio, "", "Servicio", (data) => {
    guardarServicio(data);
    
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

    console.log("📤 Enviando datos:", datos);

    $.post(`${SERVICIO_CONTROLLER_URL}?action=crearservicio`, datos, function(response) {
        console.log("📥 Respuesta del servidor:", response);

        if (response && response.success) {
            showToast("Servicio guardada correctamente", "success");
            servicios.push(response.servicios);
            $('#modalCita').modal('hide');
        } else {
            showToast("Error al guardar el servicio: " + (response?.message || "Desconocido"), "error");
        }
    }, 'json').fail(function(xhr, status, error) {
        console.error("🚨 Error AJAX:", error, xhr.responseText);
        showToast("Error en el servidor: " + error, "error");
    });
}


// Función para eliminar un servicio
function eliminarServicio(id) {
    const mensaje = `¿Estás seguro de que deseas eliminar este servicio? `;
showConfirmation(mensaje, () => {
       $.ajax({
    url: `${SERVICIO_CONTROLLER_URL}?action=eliminarServicio`,
    type: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function(response) {
        if (response.success) {
            showToast("Servicio eliminado correctamente", "success");
        } else {
            showToast("Error al eliminar el Servicio: " + response.message, "error");
        }
    },
    error: function(xhr, status, error) {
        showToast("Error en el servidor: " + error, "error");
    }
});
     }, () => { // callback si cancela
        showToast('Acción cancelada', 'warning');
    });
}

//.........................................................
//dejar controlador optimocon estandares utilidades en metodos para evitar codigo este va ser el ejemplo 
// optimizar metodos eliminar guardar para que tamsolo con llamarlo y pasarle datos funcione solucionar problema de que no actualiza el registro 
// eliinado o mostrando agregado
</script>

<script src="<?php echo JQUERY_JS; ?>"></script>

