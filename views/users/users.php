<!-- Include jQuery and DataTables Libraries -->

<!-- DataTables Responsive Extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<body>
<style type="text/css">
/* Celda que contiene los botones */
td .action-buttons {
    display: flex;
    justify-content: center; /* centrado horizontal */
    align-items: center;     /* centrado vertical */
    gap: 8px;                /* espacio entre botones */
}

/* Todos los botones de acción: mismo tamaño y forma */
.btn-edit,
.btn-delete,
.btn-toggle {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;       /* forma circular */
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    font-size: 18px;
    color: #fff;
    padding: 0;
}

/* Editar: amarillo/dorado */
.btn-edit {
    background: linear-gradient(135deg,#FFD24D,#D4A017);
}
.btn-edit:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(212,175,55,0.4);
}

/* Eliminar: rojo */
.btn-delete {
    background: linear-gradient(135deg,#FF6B6B,#FF3B3B);
}
.btn-delete:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(255,59,59,0.4);
}

/* Activar/Inactivar: fondo circular dinámico según estado */
.btn-toggle {
    background: #111; /* fondo oscuro */
}
.btn-toggle i.fa-check-circle { 
    color: #34D399; /* verde */
}
.btn-toggle i.fa-times-circle { 
    color: #FF3B3B; /* rojo */
}
.btn-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Opcional: suaviza el cambio de color del ícono al toggle */
.btn-toggle i {
    transition: color 0.2s ease;
}

/* Contenedor de la paginación */
.dataTables_info,
.dataTables_paginate {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #f0f0f0;
    margin-top: 10px;
}

/* Información "Mostrando X de X registros" */
.dataTables_info {
    display: inline-block;
    padding: 5px 10px;
}

/* Botones de paginación */
.dataTables_paginate .paginate_button {
    background: #2a2a2a;
    color: #fff !important;
    border: none;
    border-radius: 6px;
    padding: 5px 12px;
    margin: 0 2px;
    cursor: pointer;
    transition: all 0.2s;
}

/* Hover en botones */
.dataTables_paginate .paginate_button:hover {
    background: #3d3d3d;
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

/* Botón activo */
.dataTables_paginate .paginate_button.current {
    background: #FFD24D;
    color: #111 !important;
    font-weight: bold;
    box-shadow: 0 2px 10px rgba(255,210,77,0.5);
}


</style>
  <table id="usuarios" class="table table-bordered table-hover dt-responsive">
    <caption class="table-caption">Usuarios Registrados</caption>
  <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nombre Completo</th>
                    <th>Fecha de Registro</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Edad</th>
                    <th>id</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre_completo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['edad']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                     
<td>
    <div class="action-buttons">
        <button class="btn-edit" title="Editar" onclick="abrirModalEditar(<?= $usuario['id'] ?>)">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn-delete" title="Eliminar" onclick="eliminarUsuario(<?= $usuario['id'] ?>)">
            <i class="fas fa-trash-alt"></i>
        </button>
       <button class="btn-toggle" 
        title="Activar/Inactivar" 
        onclick="toggleUsuario(<?= $usuario['id'] ?>, '<?= $usuario['estado'] ?>')">
    <?php if($usuario['estado'] === 'activo'): ?>
        <i class="fas fa-check-circle"></i>
    <?php else: ?>
        <i class="fas fa-times-circle"></i>
    <?php endif; ?>
</button>
    </div>
</td>
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="text-center">.</td>
                </tr>
            </tfoot>
  </table>

<div id="modalEditar" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarModalEditar()">&times;</span>
        <h2>Editar Usuario</h2>
        <form id="formEditarUsuario" class="form-container">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="accion" value="editar">
            
            <!-- Campos de entrada -->
            <div class="input-group">
                <label for="edit-username">Username</label>
                <input type="text" name="username" id="edit-username" required placeholder="Ingresa el username">
            </div>

            <div class="input-group">
                <label for="edit-email">Email</label>
                <input type="email" name="email" id="edit-email" required placeholder="Ingresa el email">
            </div>

            <div class="input-group">
                <label for="edit-nombre_completo">Nombre Completo</label>
                <input type="text" name="nombre_completo" id="edit-nombre_completo" required placeholder="Ingresa el nombre completo">
            </div>

            <div class="input-group">
                <label for="edit-telefono">Teléfono</label>
                <input type="text" name="telefono" id="edit-telefono" placeholder="Ingresa el teléfono">
            </div>

            <div class="input-group">
                <label for="edit-direccion">Dirección</label>
                <input type="text" name="direccion" id="edit-direccion" placeholder="Ingresa la dirección">
            </div>

            <div class="input-group">
                <label for="edit-edad">Edad</label>
                <input type="number" name="edad" id="edit-edad" placeholder="Ingresa edad">
            </div>

            <div class="input-group">
                <label for="edit-estado">Estado</label>
                <select name="estado" id="edit-estado">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="input-group">
    <label for="edit-rol">Rol</label>
    <select name="rol" id="edit-rol">
        <option value="usuario">Usuario</option>
        <option value="admin">Admin</option>
        <option value="cliente">Cliente</option>
    </select>
</div>

            <button type="button" onclick="editarUsuario()" class="btn-save">Guardar Cambios</button>
        </form>
    </div>
</div>
</body>
