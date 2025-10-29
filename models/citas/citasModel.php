<?php
require_once __DIR__ . '/../../config/config.php';

class CitaModel {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listarClientes() {
    $sql = "SELECT id, nombre_completo FROM usuarios WHERE rol = 'cliente' AND estado = 'activo' ORDER BY nombre_completo";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarCitas() {
        $sql = " SELECT 
                    c.id,
                    u.nombre_completo,
                    u.telefono,
                    c.fecha_cita,
                    c.hora_cita,
                    c.duracion_minutos,
                    c.estado,
                    c.comentarios
               FROM citas c
               JOIN usuarios u ON c.cliente_id = u.id
               ORDER BY c.fecha_cita, c.hora_cita
               LIMIT 0, 25;";
               
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function crearCita($datos) {
    $sql = "INSERT INTO citas (
                cliente_id, 
                servicio_id, 
                empleado_id, 
                fecha_cita, 
                hora_cita, 
                duracion_minutos, 
                estado, 
                comentarios, 
                creada_por
            ) VALUES (
                :cliente_id, 
                :servicio_id, 
                :empleado_id, 
                :fecha_cita, 
                :hora_cita, 
                :duracion_minutos, 
                :estado, 
                :comentarios, 
                :creada_por
            )";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($datos);
}

    public function actualizarEstado($id, $estado) {
        $sql = "UPDATE citas SET estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);  
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    public function eliminarCita($id) {
        $sql = "DELETE FROM citas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
