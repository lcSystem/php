<?php
// ==========================
// UTILIDADES PHP
// ==========================


// Extrae datos de $_POST aplicando valores por defecto
function extraerDatos(array $campos) {
    $datos = [];
    foreach ($campos as $campo => $defecto) {
        $datos[$campo] = $_POST[$campo] ?? $defecto;
    }
    return $datos;
}

// Guardar registro
function guardarRegistro($model, $datos, $method) {
    try {
        $exito = $model->$method($datos);
        echo json_encode([
            'success' => $exito,
            'servicio' => $exito ? $datos : null,
            'message' => $exito ? 'Guardado correctamente' : 'Error al guardar'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Actualizar registro
function actualizarRegistro($model, $id, $datos, $method) {
    try {
        $exito = $model->$method($id, $datos);
        echo json_encode([
            'success' => $exito,
            'servicio' => $exito ? $datos : null,
            'message' => $exito ? 'Actualizado correctamente' : 'Error al actualizar'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Cambiar estado
function cambiarEstadoRegistro($model, $id, $estado,$method) {
    try {
        $filas = $model->$method($id, $estado); // usa la función correcta
        echo json_encode([
            'success' => $filas > 0,
            'estado' => $estado,
            'message' => $filas > 0 ? "Estado actualizado a $estado" : 'Error al actualizar estado'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Eliminar registro
function eliminarRegistro($model, $id, $method) {
    try {
        $filas = $model->$method($id);
        echo json_encode([
            'success' => $filas > 0,
            'message' => $filas > 0 ? 'Eliminado correctamente' : 'No se pudo eliminar o no existe'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

