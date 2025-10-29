<?php
require_once __DIR__ . '/../../config/config.php';

class Servicios {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Listar todos los servicios
    public function listarServicios() {
        $sql = "SELECT id, nombre, descripcion, duracion_minutos, precio, estado
                FROM servicios 
                ORDER BY nombre";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

      // Listar todos los servicios
    public function listarServiciosInactivos() {
        $sql = "SELECT id, nombre, descripcion, duracion_minutos, precio, estado
                FROM servicios 
                WHERE estado = 'activo'
                ORDER BY nombre";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un servicio por ID
    public function obtenerPorId($id) {
        $sql = "SELECT id, nombre, descripcion, duracion_minutos, precio, estado
                FROM servicios 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $servicio = $stmt->fetch(PDO::FETCH_ASSOC);
        return $servicio ?: null;
    }

    // Crear un nuevo servicio
    public function crearServicio($datos) {
        $sql = "INSERT INTO servicios (nombre, descripcion, duracion_minutos, precio, estado) 
                VALUES (:nombre, :descripcion, :duracion_minutos, :precio, :estado)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':duracion_minutos' => $datos['duracion_minutos'],
            ':precio' => $datos['precio'],
            ':estado' => $datos['estado']
        ]);
    }

    // Actualizar un servicio completo
    public function actualizarServicio($id, $datos) {
        $sql = "UPDATE servicios 
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    duracion_minutos = :duracion_minutos,
                    precio = :precio,
                    estado = :estado
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':duracion_minutos' => $datos['duracion_minutos'],
            ':precio' => $datos['precio'],
            ':estado' => $datos['estado'],
            ':id' => $id
        ]);
    }

    // Cambiar solo el estado de un servicio
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE servicios SET estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':estado' => $estado,
            ':id' => $id
        ]);
        return $stmt->rowCount();
    }

    // Eliminar un servicio
    public function eliminarServicio($id) {
        $sql = "DELETE FROM servicios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount(); 
    }
}
