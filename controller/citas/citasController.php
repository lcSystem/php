<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once CITAS_MODEL;

class CitaController {
    private $citaModel;

    public function __construct() {
        $this->citaModel = new CitaModel();
    }

    public function index() {
        $citas = $this->citaModel->listarCitas();
        $clientes = $this->citaModel->listarClientes();
         require_once CITAS_VIEW;
       
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            switch ($_POST['accion']) {
                case 'crear':
                    $datos = [
                        ':usuario_id' => $_POST['usuario_id'],
                        ':fecha' => $_POST['fecha'],
                        ':hora' => $_POST['hora'],
                        ':servicio' => $_POST['servicio'],
                        ':notas' => $_POST['notas'] ?? null
                    ];
                    $ok = $this->citaModel->crearCita($datos);
                    echo json_encode(['success' => $ok]);
                    break;

                case 'cambiar_estado':
                    $ok = $this->citaModel->actualizarEstado($_POST['id'], $_POST['estado']);
                    echo json_encode(['success' => $ok]);
                    break;

                case 'eliminar':
                    $ok = $this->citaModel->eliminarCita($_POST['id']);
                    echo json_encode(['success' => $ok]);
                    break;

                default:
                    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            }
            exit;
        }
    }
}

$controller = new CitaController();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->index();
} else {
    $controller->handleRequest();
}
