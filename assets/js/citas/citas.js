 
// Campos que tendrá el formulario
const camposCita = [
  { nombre: "cliente", etiqueta: "cliente", tipo: "select", opciones: [
             { value: "jairo", text: "jairo" },
             { value: "mara", text: "mara" },
             { value: "andrea", text: "andrea" }
                                                                        ] 
  },
  { nombre: "fecha", etiqueta: "Fecha", tipo: "date" },
  { nombre: "hora", etiqueta: "Hora", tipo: "time" },
  { nombre: "servicio", etiqueta: "Servicio", tipo: "select", opciones: [
             { value: "corte", text: "Corte" },
             { value: "manicure", text: "Manicure" },
             { value: "pedicure", text: "Pedicure" }
                                                                        ] 
  },
  { nombre: "observaciones", etiqueta: "Observaciones", tipo: "textarea" }

];

function abrirCita() {
  abrir(camposCita, {}, "Nueva Cita", (data) => {
    console.log("Nueva cita guardada:", data);
  });
}

function abrirCitaConDatos() {
  const valores = {
    id: 1,
    cliente: "Juan Pérez",
    fecha: "2025-10-20",
    hora: "10:00",
    servicio: "corte",
    observaciones: "Traer foto de referencia"
  };
  
  abrir(camposCita, valores, "Editar Cita", (data) => {
    console.log("Cita editada:", data);
  });
}








// Función para abrir el modal de edición y cargar los datos del usuario
function abrirModalEditar(id) {
    $.get('../controller/userController.php', { accion: 'obtener', id: id }, function(usuario) {
        if (usuario) {
            $('#edit-id').val(usuario.id);
            $('#edit-username').val(usuario.username);
            $('#edit-email').val(usuario.email);
            $('#edit-nombre_completo').val(usuario.nombre_completo);
           

            $('#modalCita').show();
        } else {
            alert("No se pudieron cargar los datos del usuario.");
        }
    }).fail(function() {
        alert("Error al obtener los datos del usuario.");
        $('#modalCita').hide();
    });
}

function guardarCita(){
    const cliente = $('#cliente').val();
    const hora = parseInt($('#hora').val().split(':')[0]);
    const servicio = $('#servicio').val();
    const slotId = 'slot-0-'+hora;
    const colorClass = 'servicio-'+servicio;
    const logo = 'https://via.placeholder.com/28';
    $('#'+slotId).append(`
        <div class="cita-block ${colorClass}">
            <img src="${logo}" alt="${cliente}">
            <span>${cliente} - ${servicio}</span>
        </div>
    `);
    $('#modalCita').modal('hide');
}
