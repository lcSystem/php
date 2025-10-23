<?php
/**
 * $idTable: id HTML de la tabla
 * $caption: texto del caption
 * $columns: array de columnas ['key' => 'Label']
 * $data: array de arrays/objetos con los datos
 * $actions: array de acciones ['editar' => 'abrirModalEditar', 'eliminar' => 'eliminarUsuario', 'toggle' => 'toggleUsuario']
 */

function renderTable($idTable, $caption, $columns, $data, $actions = []) {
?>
<table id="<?= $idTable ?>" class="table table-bordered table-hover dt-responsive">
    <caption class="table-caption"><?= htmlspecialchars($caption) ?></caption>
    <thead>
        <tr>
            <?php foreach ($columns as $key => $label): ?>
                <th><?= htmlspecialchars($label) ?></th>
            <?php endforeach; ?>
            <?php if (!empty($actions)) echo '<th>Acciones</th>'; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <?php foreach ($columns as $key => $label): ?>
                    <td><?= htmlspecialchars($row[$key] ?? '') ?></td>
                <?php endforeach; ?>
                <?php if (!empty($actions)): ?>
                    <td>
                        <div class="action-buttons">
                            <?php if (isset($actions['editar'])): ?>
                                <button class="btn-edit" title="Editar" onclick="<?= $actions['editar'] ?>(<?= $row['id'] ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                            <?php endif; ?>
                            <?php if (isset($actions['eliminar'])): ?>
                                <button class="btn-delete" title="Eliminar" onclick="<?= $actions['eliminar'] ?>(<?= $row['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            <?php endif; ?>
                            <?php if (isset($actions['toggle'])): ?>
                                <button class="btn-toggle" title="Activar/Inactivar" onclick="<?= $actions['toggle'] ?>(<?= $row['id'] ?>, '<?= $row['estado'] ?>') ?>">
                                    <?php if(($row['estado'] ?? '') === 'activo'): ?>
                                        <i class="fas fa-check-circle"></i>
                                    <?php else: ?>
                                        <i class="fas fa-times-circle"></i>
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="<?= count($columns) + (empty($actions) ? 0 : 1) ?>" class="text-center">.</td>
        </tr>
    </tfoot>
</table>
<?php
}
