<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/paths.php';
require_once SERVICIOS_MODEL;

class ServiciosController {
    private $model;
    private $servicios;

    public function __construct() {
        $this->model = new Servicios();
        $this->servicios = $this->model->listarServicios();
    }

    public function index() {
        $servicios = $this->servicios; 
        require_once SERVICIOS_VIEW;
    }

public function crearservicio() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    $datos = [
        'id'       =>           $_POST['id'] ?? 0,
        'nombre'      =>        $_POST['nombre'] ?? 0,
        'descripcion'      =>   $_POST['descripcion'] ?? null,
        'duracion_minutos' =>   $_POST['duracion_minutos'] ?? '',
        'estado'        =>      $_POST['estado'] ?? 'activo',
        'precio' =>             $_POST['precio'] ?? 1000
    ];

    try {
        $exito = $this->model->crearServicio($datos);

        if ($exito) {
            echo json_encode(['success' => true, 'servicio' => $datos]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error en INSERT del modelo']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit;
}

public function eliminarServicio($id) {
    $filasEliminadas = $this->model->eliminarServicio($id);

    echo json_encode([
        'success' => $filasEliminadas > 0,
        'message' => $filasEliminadas > 0
            ? 'Servicio eliminado correctamente'
            : 'Error al eliminar el servicio o no existe el ID'
    ]);
    exit;
}

}

$ctrl = new ServiciosController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'crearservicio':
        $ctrl->crearservicio();
        break;
    case 'eliminarServicio':
    $ctrl->eliminarServicio($_POST['id'] ?? 0);
    break;
    default:
        $ctrl->index();
        break;
}