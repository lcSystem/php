<?php
/**
 * $idTable: id HTML de la tabla
 * $caption: texto del caption
 * $columns: array de columnas ['key' => 'Label']
 * $data: array de arrays/objetos con los datos
 * $actions: array de acciones ['editar' => 'abrirModalEditar', 'eliminar' => 'eliminarUsuario', 'toggle' => 'toggleUsuario']
 */

function renderTable($idTable, $caption, $columns, $data, $actions = [], $addButton = null) {

?>

<?php if ($addButton): ?>
    <div class="mb-2">
        <button class="<?= htmlspecialchars($addButton['class'] ?? 'btn btn-primary') ?>" 
                onclick="<?= htmlspecialchars($addButton['onClick']) ?>">
            <?= htmlspecialchars($addButton['label']) ?>
        </button>
    </div>
<?php endif; ?>

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
                    <td>  <?php 
            if ($key === 'precio' && isset($row[$key])) {
                echo number_format((float)$row[$key], 0, ',', '.');
            } else {
                echo htmlspecialchars($row[$key] ?? '');
            }
        ?></td>
                <?php endforeach; ?>
               <?php if (!empty($actions)): ?>
<td>
    <div class="action-buttons">
<?php if (isset($actions['editar'])): ?>
<?php 
    // Convierte el objeto PHP a JSON y escapa comillas simples
    $jsonData = json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); 
?>
<button class="btn-edit" title="Editar" 
        onclick='<?= $actions['editar'] ?>(<?= (int)$row['id'] ?>, <?= $jsonData ?>)'>
    <i class="fas fa-edit"></i>
</button>
<?php endif; ?>
        <?php if (isset($actions['eliminar'])): ?>
            <button class="btn-delete" title="Eliminar" onclick="<?= $actions['eliminar'] ?>(<?= json_encode($row['id']) ?>)">
                <i class="fas fa-trash-alt"></i>
            </button>
        <?php endif; ?>
      <?php if (isset($actions['toggle'])): ?>
            <?php $estado = ($row['estado'] ?? 'activo') === 'activo' ? 'activo' : 'inactivo'; ?>
            <button class="btn-toggle" title="Activar/Inactivar" 
                    onclick="<?= $actions['toggle'] ?>(<?= (int)$row['id'] ?>, '<?= addslashes($estado) ?>')">
                <?php if($estado === 'activo'): ?>
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
