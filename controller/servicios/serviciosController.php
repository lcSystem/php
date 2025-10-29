<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once SERVICIOS_MODEL;
require_once UT_UTILIDADES_PHP; // archivo con funciones CRUD genéricas

class ServiciosController {
    private $model;
    private $servicios;

    public function __construct() {
        $this->model = new Servicios();
        $this->servicios = $this->model->listarServicios();
    }

    public function index() {
           if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
                echo "<div class='card'><h3>Acceso denegado</h3><p>No tienes permisos para acceder a esta sección.</p></div>";
            return; 
    }

        $servicios = $this->servicios; 
        require_once SERVICIOS_VIEW;
    }
    
    public function crearservicio() {
        $campos = [
            'nombre' => '',
            'descripcion' => null,
            'duracion_minutos' => 60,
            'estado' => 'activo',
            'precio' => 1000
        ];
        $datos = extraerDatos($campos);
        guardarRegistro($this->model, $datos, 'crearServicio');
    }

    public function actualizarServicio() {
        $id = $_POST['id'] ?? 0;
        $campos = [
            'nombre' => '',
            'descripcion' => null,
            'duracion_minutos' => 60,
            'estado' => 'activo',
            'precio' => 1000
        ];
        $datos = extraerDatos($campos);
        actualizarRegistro($this->model, $id, $datos, 'actualizarServicio');
    }

    public function cambiarEstado() {
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? 'activo';
        cambiarEstadoRegistro($this->model, $id, $estado, 'cambiarEstado');
    }

    public function eliminarServicio() {
        $id = $_POST['id'] ?? 0;
        eliminarRegistro($this->model, $id, 'eliminarServicio');
    }
}

// Disparar acción
$ctrl = new ServiciosController();
$action = $_GET['action'] ?? 'index';

if (in_array($action, ['crearservicio','actualizarServicio','cambiarEstado','eliminarServicio'])) {
    $ctrl->$action();
    exit; 
} else {
    $ctrl->index();
}