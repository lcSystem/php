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