<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {
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

  public function verificarExistencia($username, $email) {
        $sql = "SELECT id,username FROM usuarios WHERE username = :username OR email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el usuario si existe o `null` si no
    }


    public function registrar($username, $email, $password, $nombreCompleto, $telefono, $direccion, $edad, $sexo) {
        $sql = "INSERT INTO usuarios (username, email, password, nombre_completo, telefono, direccion, edad, sexo, rol) 
                VALUES (:username, :email, :password, :nombre_completo, :telefono, :direccion, :edad, :sexo, 'cliente')";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':nombre_completo', $nombreCompleto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':sexo', $sexo);
        
        return $stmt->execute();
    }


    public function login($identifier, $password) {
        $sql = "SELECT * FROM usuarios WHERE username = :identifier OR email = :identifier LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el usuario si existe
    }

           // --- NUEVOS PARA PERFIL ---

    // 1. Obtener usuario por ID
public function obtenerPorId($id) {
    $sql = "SELECT id, username, email, nombre_completo, telefono, direccion, edad, sexo, avatar, estado, rol
            FROM usuarios 
            WHERE id = :id 
            LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

  // Actualizar datos de usuario (sin foto)
    public function actualizarDatos($id, $nombreCompleto, $email, $telefono, $direccion, $edad, $sexo) {
        $sql = "UPDATE usuarios 
                SET nombre_completo = :nombre_completo, 
                    email = :email, 
                    telefono = :telefono, 
                    direccion = :direccion, 
                    edad = :edad, 
                    sexo = :sexo
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre_completo', $nombreCompleto);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

     public function editarUsuario($id, $datos) {
        $sql = "UPDATE usuarios SET 
                    username = :username, 
                    email = :email, 
                    nombre_completo = :nombre_completo,
                    estado = :estado,
                    telefono = :telefono,
                    direccion = :direccion,
                    edad = :edad,
                    rol = :rol
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $datos['username']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':nombre_completo', $datos['nombre_completo']);
        $stmt->bindParam(':estado', $datos['estado']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':edad', $datos['edad']);
        $stmt->bindParam(':rol', $datos['rol']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // esto devuelve true o false
    }

    // Actualizar solo la foto de perfil
    public function actualizarFoto($id, $foto) {
        $sql = "UPDATE usuarios 
                SET avatar = :foto 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 🔑 Nuevo: actualizar contraseña
    public function actualizarPassword($id, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios 
                SET password = :password 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function actualizarEstado($id, $estado) {
    $sql = "UPDATE usuarios SET estado = :estado WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

public function getUserByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function saveResetToken($userId, $token, $expiry) {
    $stmt = $this->db->prepare("UPDATE usuarios SET password_reset_token = :token, password_reset_expires = :expiry WHERE id = :id");
    $stmt->execute([
        'token' => $token,
        'expiry' => $expiry,
        'id' => $userId
    ]);
}

// Incrementa intentos fallidos
public function incrementarIntento($id) {
    $sql = "UPDATE usuarios 
            SET intentos_fallidos = intentos_fallidos + 1 
            WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Reinicia los intentos al hacer login correcto
public function resetearIntentos($id) {
    $sql = "UPDATE usuarios 
            SET intentos_fallidos = 0 
            WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Inactiva usuario
public function inactivarUsuario($id) {
    $sql = "UPDATE usuarios 
            SET estado = 'inactivo' 
            WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}


}
?>