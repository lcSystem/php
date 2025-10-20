<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once REGISTER_MODEL;
require_once USER_MODEL; // Asegúrate de incluir tu modelo Usuario

class UserController {

    public function mostrarUsuarios() {
        $usuarioModel = new usuarioRegistro();
        $usuarios = $usuarioModel->listarUsuarios();
        require_once USERS_VIEW;
    }

    // Manejo de solicitudes GET y POST
    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET' && isset($_GET['accion'])) {
            $accion = $_GET['accion'];
            $id = $_GET['id'] ?? null;

            if ($accion === 'obtener' && $id) {
                $this->obtenerUsuario($id);
            } else {
                echo json_encode(['success' => false, 'message' => 'Acción GET no válida']);
            }
            exit;
        }

        if ($method === 'POST' && isset($_POST['accion'])) {
            $accion = $_POST['accion'];
            $id = $_POST['id'] ?? null;

            if ($accion === 'eliminar' && $id) {
                $this->eliminarUsuario($id);
            } elseif ($accion === 'editar' && $id) {
                $datos = [
                    'username' => $_POST['username'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'nombre_completo' => $_POST['nombre_completo'] ?? '',
                    'estado' => $_POST['estado'] ?? 'activo',
                    'telefono' => $_POST['telefono'] ?? '',
                    'direccion' => $_POST['direccion'] ?? '',
                    'edad' => $_POST['edad'] ?? '', // coincide con el input del formulario
                    'rol' => $_POST['rol'] ?? '',
                    'avatar' => $_POST['avatar'] ?? ''
                ];
                $this->editarUsuario($id, $datos);
            } elseif ($accion === 'cambiar_estado' && $id && isset($_POST['estado'])) {
    $usuarioModel = new Usuario();
    $resultado = $usuarioModel->actualizarEstado($id, $_POST['estado']); // nueva función en el modelo
    echo json_encode([
        'success' => $resultado,
        'message' => $resultado ? 'Estado actualizado correctamente' : 'Error al actualizar el estado'
    ]);
    exit;
} else {
                echo json_encode(['success' => false, 'message' => 'Acción POST no válida o ID no proporcionado']);
            }
            exit;
        }
    }

    public function obtenerUsuario($id) {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorId($id);

        if ($usuario) {
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
        exit;
    }

    public function eliminarUsuario($id) {
        $usuarioModel = new usuarioRegistro();
        $resultado = $usuarioModel->eliminarUsuario($id);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Usuario eliminado correctamente' : 'Error al eliminar el usuario'
        ]);
        exit;
    }

    public function editarUsuario($id, $datos) {
        $usuarioModel = new Usuario();
        $resultado = $usuarioModel->editarUsuario($id, $datos);

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al editar el usuario']);
        }
        exit;
    }
}

// Ejecutar el controlador
$controller = new UserController();
$controller->handleRequest();