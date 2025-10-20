<?php
require_once CITAS_MODEL;
require_once __DIR__ . '/../../models/userModel.php';

class CitaController {
    private $citaModel;
    private $usuarioModel;

    public function __construct() {
        $this->citaModel = new CitaModel();
        $this->usuarioModel = new Usuario();
    }

   public function getSessionUserId(): int {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Revisar varias posibilidades como en PerfilController
    $candidates = ['id', 'user_id', 'userId', 'usuario_id'];
    foreach ($candidates as $k) {
        if (!empty($_SESSION[$k])) {
            return intval($_SESSION[$k]);
        }
    }

    // soporte para arrays en sesión (ej: $_SESSION['user']['id'] o $_SESSION['usuario']['id'])
    if (!empty($_SESSION['user']['id'])) return intval($_SESSION['user']['id']);
    if (!empty($_SESSION['usuario']['id'])) return intval($_SESSION['usuario']['id']);

    return 0;
}

    public function index() {
        $idUsuario = $this->getSessionUserId();

        $usuario = $this->usuarioModel->obtenerPorId($idUsuario);

   if (!$usuario) {
        $usuario = ['id' => 0, 'nombre_completo' => 'Desconocido'];
    }

        // Cargar citas y clientes según rol
        $citas = $this->citaModel->listarCitas();
       
        if ($_SESSION['user_rol'] === 'admin' || $_SESSION['user_rol'] === 'usuario' ) {
            $clientes = $this->citaModel->listarClientes();
        } else {
            $clientes = [$usuario];
        }

        require_once CITAS_VIEW;
        return $usuario;
    }
}


// --- fuera de la clase ---
$ctrl = new CitaController();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ctrl->index();
}
