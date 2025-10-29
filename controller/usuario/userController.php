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
        return; 
        }

        $usuarios = $this->usuarios;
        require_once USERS_VIEW;
    }

    // === Crear usuario ===
    public function crearUsuario() {
         $campos = [
            'username'        => '',
            'email'           => '',
            'password'        => '',
            'nombre_completo' => '',
            'telefono'        => '',
            'direccion'       => '',
            'edad'            => '',
            'estado'          => 'activo',
            'rol'             => 'usuario',
            'sexo'            => 'M' 
            ];
       
    $datos = extraerDatos($campos);

    if (!empty($datos['password'])) {
        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
    }

    guardarRegistro($this->model, $datos, 'registrar');

    }

    // === Actualizar usuario ===
    public function actualizarUsuario() {
        $id = $_POST['id'] ?? 0;

         $campos = [
            'username'        => '',
            'email'           => '',
            'password'        => '',
            'nombre_completo' => '',
            'telefono'        => '',
            'direccion'       => '',
            'edad'            => '',
            'estado'          => 'activo',
            'rol'             => 'usuario',
            'sexo'            => 'M' 
            ];

        $datos = extraerDatos($campos);

         if (!empty($datos['password'])) {
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
             }
       
       

       actualizarRegistro($this->model, $id, $datos, 'editarUsuario');
    }


    // === Cambiar estado ===
    public function cambiarEstado() {

          $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? 'activo';
        cambiarEstadoRegistro($this->model, $id, $estado, 'actualizarEstado');
    }

    // === Eliminar usuario ===
    public function eliminarUsuario() {
          $id = $_POST['id'] ?? 0;
        eliminarRegistro($this->model, $id, 'eliminarUsuario');
    }

    // === Obtener usuario por ID ===
    public function obtenerUsuario($id) {
        $usuario = $this->model->obtenerPorId($id);
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
