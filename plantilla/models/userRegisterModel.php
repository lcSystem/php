<?php
// Incluir la conexión a la base de datos
require_once '../config/config.php';

class usuarioRegistro {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listarUsuarios() {
        $sql = "SELECT id, username, email, nombre_completo, fecha_registro, estado, telefono, direccion, edad, avatar, rol 
                FROM usuarios";
        $stmt = $this->pdo->prepare($sql);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  public function eliminarUsuario($id) {
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID no válido']);
            exit;
        }

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);  

        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
            exit;
        }

        // Vincula el ID y ejecuta la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editarUsuario($id, $datos){
        $sql = "UPDATE usuarios SET 
                username = :username, 
                email = :email, 
                nombre_completo = :nombre_completo, 
                estado = :estado, 
                telefono = :telefono, 
                direccion = :direccion, 
                edad = :edad, 
                avatar = :avatar, 
                rol = :rol
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $datos['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre_completo', $datos['nombre_completo'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':edad', $datos['edad'], PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $datos['avatar'], PDO::PARAM_STR);
        $stmt->bindParam(':rol', $datos['rol'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Método para cambiar el estado del usuario a 'activo' o 'inactivo'
    public function cambiarEstado($username, $estado) {
        $sql = "UPDATE usuarios SET estado = :estado WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':username', $username);
        return $stmt->execute();
    }


}
?>

