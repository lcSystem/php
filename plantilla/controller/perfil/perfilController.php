<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
// controller/perfil/perfilController.php

require_once __DIR__ . '/../../models/userModel.php';
require_once __DIR__ . '/../../config/paths.php';


class PerfilController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario(); // clase definida en userModel.php
    }

    /**
     * Intenta obtener el id de usuario desde sesión (varios nombres soportados)
     */
    public function getSessionUserId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $candidates = ['id', 'user_id', 'userId', 'usuario_id'];
        foreach ($candidates as $k) {
            if (!empty($_SESSION[$k])) {
                return intval($_SESSION[$k]);
            }
        }
        // soporte para arrays en sesión (ej: $_SESSION['user']['id'])
        if (!empty($_SESSION['user']['id'])) return intval($_SESSION['user']['id']);
        if (!empty($_SESSION['usuario']['id'])) return intval($_SESSION['usuario']['id']);

        return 0;
    }

    // Mostrar perfil de un usuario
    public function mostrarPerfil(int $idUsuario) : array {
        if ($idUsuario <= 0) return [];
        $u = $this->usuarioModel->obtenerPorId($idUsuario);
        return $u ?: [];
    }

    // Actualizar datos del perfil (sin contraseña)
    public function actualizarPerfil(int $idUsuario, array $datos) : bool {
        // saneamiento mínimo (puedes reforzar validaciones aquí)
        $nombre = $datos['nombre_completo'] ?? '';
        $email  = $datos['email'] ?? '';
        $telefono = $datos['telefono'] ?? null;
        $direccion = $datos['direccion'] ?? null;
        $edad = isset($datos['edad']) && $datos['edad'] !== '' ? intval($datos['edad']) : null;
        $sexo = $datos['sexo'] ?? null;

        return $this->usuarioModel->actualizarDatos(
            $idUsuario,
            $nombre,
            $email,
            $telefono,
            $direccion,
            $edad,
            $sexo
        );
    }

    // Actualizar contraseña (si llegase). Usa el método del model si existe, si no hace query directa.
    public function actualizarPassword(int $idUsuario, string $password) : bool {
        if (empty($password) || $idUsuario <= 0) return false;
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // si el model implementa actualizarPassword, úsalo
        if (method_exists($this->usuarioModel, 'actualizarPassword')) {
            return $this->usuarioModel->actualizarPassword($idUsuario, $password);
        }

        // fallback: usar $pdo del config directamente
        global $pdo;
        if (!isset($pdo)) return false;
        $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

public function actualizarFoto(int $idUsuario, array $archivo) : bool {
    if ($idUsuario <= 0) {
        echo "ID de usuario inválido"; // depuración
        return false;
    }

    // Caso: eliminar foto
    if (empty($archivo) || (isset($archivo['name']) && $archivo['name'] === '')) {
        $usuario = $this->mostrarPerfil($idUsuario);
        if (!empty($usuario['avatar'])) {
            $old = $this->getUploadsPath() . $usuario['avatar'];
           // echo "Borrando archivo anterior: $old\n"; // depuración
            if (file_exists($old)) @unlink($old);
        }
        return $this->usuarioModel->actualizarFoto($idUsuario, null);
    }

    // Validar errores del upload
    if (!isset($archivo['error']) || $archivo['error'] !== UPLOAD_ERR_OK) {
        echo "Error en upload: " . ($archivo['error'] ?? 'No seteado') . "\n"; // depuración
        return false;
    }

    // Validar tamaño máximo (2MB)
    if (isset($archivo['size']) && $archivo['size'] > 4 * 1024 * 1024) {
        echo "Archivo demasiado grande: " . $archivo['size'] . "\n"; // depuración
        return false;
    }

    // Validar tipo MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $archivo['tmp_name']);
    finfo_close($finfo);
    //echo "MIME detectado: $mime\n"; // depuración
    $allowedMimes = [
    'image/jpeg',   // JPG/JPEG estándar
    'image/jpg',    // JPG alternativo
    'image/png',    // PNG
    'image/webp',   // WebP
    'image/heic',   // HEIC iPhone
    'image/heif',   // HEIF iPhone
    'image/avif',   // AVIF
    'image/gif',    // GIF animado o no
    'image/tiff'    // TIFF
];
    if (!in_array($mime,  $allowedMimes)) {
        echo "Tipo de archivo no permitido\n"; // depuración
        return false;
    }

    // Preparar nombre y ruta final
    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreArchivo = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $destinoFisico = $this->getUploadsPath() . $nombreArchivo;

    // Crear carpeta si no existe
    if (!is_dir($this->getUploadsPath())) {
        echo "Creando carpeta uploads: " . $this->getUploadsPath() . "\n"; // depuración
        mkdir($this->getUploadsPath(), 0777, true);
    }

    // Mover archivo subido
    if (move_uploaded_file($archivo['tmp_name'], $destinoFisico)) {
       // echo "Archivo movido a: $destinoFisico\n"; // depuración
        // Borrar anterior si existe
        $usuario = $this->mostrarPerfil($idUsuario);
        if (!empty($usuario['avatar'])) {
            $old = $this->getUploadsPath() . $usuario['avatar'];
            if (file_exists($old)) {
              //  echo "Borrando archivo previo: $old\n"; // depuración
                @unlink($old);
            }
        }
        // Guardar nombre en BD
        return $this->usuarioModel->actualizarFoto($idUsuario, $nombreArchivo);
    }

    echo "No se pudo mover el archivo subido\n"; // depuración
    return false;
}


    // Eliminar foto (alias)
    public function eliminarFoto(int $idUsuario) : bool {
        return $this->actualizarFoto($idUsuario, ['name' => '', 'tmp_name' => '']);
    }

    // Rutas de uploads (ruta física)
private function getUploadsPath() : string {
    return $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/assets/img/uploads/';
}

// URL pública relativa para usar en HTML
public function getUploadsUrl() : string {
    return IMG_UPLOADS_URL; 
}
}


if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    session_start();

    $ctrl = new PerfilController();
    $idUsuario = $ctrl->getSessionUserId();

    if ($idUsuario <= 0) {
        header("Location: ../../login.php");
        exit;
    }

    // POST handlers
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // actualizar datos
        if (isset($_POST['actualizarDatos'])) {
            $ctrl->actualizarPerfil($idUsuario, $_POST);
            if (!empty($_POST['new_password'])) {
                $ctrl->actualizarPassword($idUsuario, $_POST['new_password']);
            }


header("Location: " . DASHBOARD_URL . "?page=perfil&success=1");
exit;

        }

        // actualizar foto
        if (isset($_POST['actualizarFoto']) && isset($_FILES['foto'])) {
            $ctrl->actualizarFoto($idUsuario, $_FILES['foto']);
            header("Location: " . DASHBOARD_URL . "?page=perfil");
exit;

        }

        // eliminar foto
        if (isset($_POST['eliminarFoto'])) {
            $ctrl->eliminarFoto($idUsuario);


header("Location: " . DASHBOARD_URL . "?page=perfil&foto=eliminada");
exit;

        }
    }

    // mostrar perfil standalone: redirige a dashboard con page=perfil (mejor UX)
    header("Location: ../../dashboard.php?page=perfil");
    exit;
}
?>