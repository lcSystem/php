<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once USER_MODEL;
require_once UT_UTILIDADES_PHP;

class UserController {
    private $model;
    private $usuarios;

    public function __construct() {
        $this->model = new Usuario();
        $this->usuarios = $this->model->listarUsuarios();
        
    }

    // Página principal (lista)
    public function index() {
   if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
    echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
    return; // ✅
}
        $usuarios = $this->usuarios;
        require_once USERS_VIEW;
    }

    // === Crear usuario ===
    public function crearUsuario() {
        $campos = [
            'username'        => '',
            'email'           => '',
            'nombre_completo' => '',
            'estado'          => 'activo',
            'telefono'        => '',
            'direccion'       => '',
            'edad'            => '',
            'rol'             => 'usuario',
            'avatar'          => ''
        ];

        $datos = extraerDatos($campos);

        try {
            $sql = "INSERT INTO usuarios (username, email, nombre_completo, estado, telefono, direccion, edad, rol, avatar) 
                    VALUES (:username, :email, :nombre_completo, :estado, :telefono, :direccion, :edad, :rol, :avatar)";
            $stmt = $this->model->pdo->prepare($sql);
            $stmt->execute($datos);

            echo json_encode([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'usuario' => $datos
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al crear usuario: ' . $e->getMessage()]);
        }
        exit;
    }

    // === Actualizar usuario ===
    public function actualizarUsuario() {
        $id = $_POST['id'] ?? 0;

        $campos = [
            'username'        => '',
            'email'           => '',
            'nombre_completo' => '',
            'estado'          => 'activo',
            'telefono'        => '',
            'direccion'       => '',
            'edad'            => '',
            'rol'             => '',
            'avatar'          => ''
        ];
        $datos = extraerDatos($campos);

        $resultado = $this->model->editarUsuario($id, $datos);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Usuario actualizado correctamente' : 'Error al actualizar usuario',
            'usuario' => $resultado ? $this->model->obtenerPorId($id) : null
        ]);
        exit;
    }

    // === Cambiar estado ===
    public function cambiarEstado() {
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? 'activo';
        $resultado = $this->model->actualizarEstado($id, $estado);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Estado actualizado correctamente' : 'Error al actualizar el estado',
            'usuario' => $resultado ? $this->model->obtenerPorId($id) : null
        ]);
        exit;
    }

    // === Eliminar usuario ===
    public function eliminarUsuario() {
        $id = $_POST['id'] ?? 0;

        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->model->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            echo json_encode([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()]);
        }
        exit;
    }

    // === Obtener usuario por ID ===
    public function obtenerUsuario($id) {
        $usuario = $this->model->obtenerPorId($id);
        echo json_encode([
            'success' => (bool)$usuario,
            'usuario' => $usuario,
            'message' => $usuario ? '' : 'Usuario no encontrado'
        ]);
        exit;
    }
}

// === Disparar acción ===
$ctrl = new UserController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if ($action === 'obtenerUsuario' && $id) {
    $ctrl->obtenerUsuario($id);
    exit;
}

if (in_array($action, ['crearUsuario','actualizarUsuario','cambiarEstado','eliminarUsuario'])) {
    $ctrl->$action();
    exit;
}

$ctrl->index();
