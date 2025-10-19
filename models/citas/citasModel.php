<?php
require_once __DIR__ . '/../config/config.php';

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
        $sql = "SELECT c.id, u.nombre_completo, u.telefono, c.fecha, c.hora, c.servicio, c.estado, c.notas
                FROM citas c
                JOIN usuarios u ON c.usuario_id = u.id
                ORDER BY c.fecha, c.hora";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCita($datos) {
        $sql = "INSERT INTO citas (usuario_id, fecha, hora, servicio, notas) 
                VALUES (:usuario_id, :fecha, :hora, :servicio, :notas)";
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
