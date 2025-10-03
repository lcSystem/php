  <!-- Bottom Nav -->
  <div class="bottom-nav">
    <button class="<?php echo !isset($_GET['page']) ? 'active' : ''; ?>" onclick="window.location='dashboard.php'">
      <i class="fa-solid fa-house"></i><span>Inicio</span>
    </button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'formulario' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=formulario'">
      <i class="fa-solid fa-file-alt"></i><span>Formularios</span>
    </button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'citas' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=citas'">
      <i class="fa-solid fa-clock"></i><span>Agenda</span>
    </button>
   <button class="<?php echo ($_GET['page'] ?? '') === 'users' ? 'active' : ''; ?>" 
        onclick="window.location='dashboard.php?page=users'"
        <?php echo (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] !== 'admin') ? 'style="display:none;"' : ''; ?>>
    <i class="fa-solid fa-user"></i><span>Usuarios</span>
</button>
    <button class="<?php echo ($_GET['page'] ?? '') === 'app' ? 'active' : ''; ?>" onclick="window.location='dashboard.php?page=config'">
      <i class="fa-solid fa-gear"></i><span>Config</span>
    </button>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
function toggleMenu() {
  document.getElementById("dropdown").classList.toggle("hidden");
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
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
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        $.post('../controller/userController.php', { 
            accion: 'eliminar', 
            id: id 
        }, function(response) {
            console.log("Respuesta del servidor: ", response); // Muestra la respuesta para verificarla

            try {
                var data = JSON.parse(response);  // Intentamos parsear la respuesta
                if (data.success) {
                    alert(data.message || 'Usuario eliminado correctamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al eliminar el usuario.');
                }
            } catch (e) {
                alert('Error al procesar la respuesta del servidor: ' + e.message);
            }
        }).fail(function(xhr, status, error) {
            alert("Error en ruta: " + error);
            console.error("Error en la petición AJAX: ", error); // Muestra más detalles de la petición fallida
        });
    }
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
    if (confirm(`¿Seguro que deseas ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} este usuario?`)) {
        $.post('../controller/userController.php', 
               { accion: 'cambiar_estado', id: id, estado: nuevoEstado }, 
               function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    const btn = document.querySelector(`button[onclick="toggleUsuario(${id}, '${estadoActual}')"]`);
                    if (btn) {
                        btn.setAttribute("onclick", `toggleUsuario(${id}, '${nuevoEstado}')`);
                        const icon = btn.querySelector("i");
                        if (nuevoEstado === 'activo') {
                            icon.classList.remove("fa-times-circle");
                            icon.classList.add("fa-check-circle");
                        } else {
                            icon.classList.remove("fa-check-circle");
                            icon.classList.add("fa-times-circle");
                        }
                    }
                } else {
                    alert(data.message || 'Error al cambiar el estado.');
                }
            } catch(e) {
                alert('Error al procesar la respuesta del servidor: ' + e.message);
            }
        }).fail(function(xhr, status, error) {
            alert("Error en la solicitud: " + error);
        });
    }
}

</script>

</html>