$(document).ready(function() {
    // Configuración de DataTables
    $('table').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        lengthChange: true,
        pageLength: 5, // Número de registros por página
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });
});

// Función para eliminar un usuario
function eliminarUsuario(id) {

    console.log("Respuesta entro ");
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        $.post(USER_CONTROLLER, { accion: 'eliminar', id: id }, function(response) {
            if (response.success) {
                alert(response.message || 'Usuario eliminado correctamente');
                location.reload();
            } else {
                alert(response.message || 'Error al eliminar el usuario.');
            }
        }).fail(function(xhr, status, error) {
            
             showToast("Error al eliminar el usuario:", "error");
        });
    }
}

// Función para abrir el modal de edición y cargar los datos del usuario
function abrirModalEditar(id) {
    $.get(USER_CONTROLLER, { accion: 'obtener', id: id }, function(usuario) {
        if (usuario) {
            $('#edit-id').val(usuario.id);
            $('#edit-username').val(usuario.username);
            $('#edit-email').val(usuario.email);
            $('#edit-nombre_completo').val(usuario.nombre_completo);
           

            $('#modalEditar').show();
        } else {
             showToast("No se pudieron cargar los datos del usuario.", "error");
        }
    }).fail(function() {
         showToast("Error al obtener los datos del usuario.", "error");
        $('#modalEditar').hide();
    });
}

// Función para cerrar el modal de edición
function cerrarModalEditar() {
    $('#modalEditar').hide();
}

// Función para editar un usuario
function editarUsuario() {
    // Verificar si el formulario es válido
    if ($('#formEditarUsuario')[0].checkValidity()) {
        const formData = $('#formEditarUsuario').serialize();
        $.post('ruta_del_controlador', formData, function(response) {
            alert(response.message || 'Usuario actualizado correctamente');
            location.reload();
        }).fail(function(xhr, status, error) {
            alert("Error al actualizar el usuario: " + error);
        });
    } else {
        alert("Por favor, completa todos los campos requeridos.");
    }
}
