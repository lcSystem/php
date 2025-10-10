   function toggleMenu() {
  document.getElementById("dropdown").classList.toggle("hidden");
}
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

function eliminarUsuario(id) {
    executeActionWithConfirmation({
        message: "¿Estás seguro de que deseas eliminar este usuario?",
        phpUrl: "../controller/userController.php",
        method: "POST",
        data: { accion: "eliminar", id: id },
        onSuccess: (res) => {
            showToast(res.message || "Usuario eliminado correctamente", "success");
            setTimeout(() => location.reload(), 1500); // recarga suave después del toast
        },
        onError: (err) => {
            showToast("Error al eliminar el usuario: " + err, "error");
        }
    });
}

// Función para abrir el modal de edición y cargar los datos del usuario
function abrirModalEditar(id) {
 $.getJSON('../controller/userController.php', { accion: 'obtener', id: id }, function(response) {
    if (response.success) {
        const usuario = response.usuario;
        $('#edit-id').val(usuario.id);
        $('#edit-username').val(usuario.username);
        $('#edit-email').val(usuario.email);
        $('#edit-nombre_completo').val(usuario.nombre_completo);
        $('#edit-telefono').val(usuario.telefono);
        $('#edit-direccion').val(usuario.direccion);
        $('#edit-edad').val(usuario.edad);
        $('#edit-estado').val(usuario.estado || 'activo');
         $('#edit-rol').val(usuario.rol);
        $('#modalEditar').show();
    } else {
        alert(response.message);
    }
}).fail(function() {
        alert("Error al obtener los datos del usuario.");
        $('#modalEditar').hide();
    });
}


// Función para cerrar el modal de edición
function cerrarModalEditar() {
    $('#modalEditar').hide();
}

// Función para editar un usuario
function editarUsuario() {
    if ($('#formEditarUsuario')[0].checkValidity()) {
        const formData = $('#formEditarUsuario').serialize(); // incluye 'accion' y 'id'
        $.post('../controller/userController.php', formData, function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    alert(data.message || 'Usuario actualizado correctamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar el usuario');
                }
            } catch(e) {
                alert('Error procesando respuesta del servidor: ' + e.message);
            }
        }).fail(function(xhr, status, error) {
            alert("Error al actualizar el usuario: " + error);
        });
    } else {
        alert("Por favor, completa todos los campos requeridos.");
    }
}

function toggleUsuario(id, estadoActual) {
    const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';
    const mensaje = `¿Seguro que deseas ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} este usuario?`;

    showConfirmation(mensaje, () => { // callback si acepta
        $.post('../controller/userController.php', 
               { accion: 'cambiar_estado', id: id, estado: nuevoEstado }, 
               function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    showToast(data.message || 'Estado actualizado correctamente', 'success');

                    // Actualizamos el botón y el icono
                    const btn = document.querySelector(`button[onclick="toggleUsuario(${id}, '${estadoActual}')"]`);
                    if (btn) {
                        btn.setAttribute("onclick", `toggleUsuario(${id}, '${nuevoEstado}')`);
                        const icon = btn.querySelector("i");
                        if (icon) {
                            if (nuevoEstado === 'activo') {
                                icon.classList.remove("fa-times-circle");
                                icon.classList.add("fa-check-circle");
                            } else {
                                icon.classList.remove("fa-check-circle");
                                icon.classList.add("fa-times-circle");
                            }
                        }
                    }
                } else {
                    showToast(data.message || 'Error al cambiar el estado', 'error');
                }
            } catch(e) {
                showToast('Error al procesar la respuesta del servidor: ' + e.message, 'error');
            }
        }).fail(function(xhr, status, error) {
            showToast("Error en la solicitud: " + error, 'error');
        });
    }, () => { // callback si cancela
        showToast('Acción cancelada', 'warning');
    });
}

